<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin\Admin;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Services\AdminService;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use Hash;
use Config;

class UserController extends Controller
{
    protected $admin;
    protected $adminService;

    public function __construct(Admin $admin,AdminService $adminService)
    {
        $this->admin=$admin;
        $this->adminService=$adminService;
    }

    public function index()//加载修改管理员信息视图
    {
        $res=$this->adminService->getUserInfo();
        $find['name']=$this->admin->where(['mobile'=>$res[0],'id'=>$res[1]])->value('name');
        $mobile = substr($res[0], 3, 4);
        $find['mobile'] = str_replace($mobile, '******', $res[0]);
        $find['id']=$res[1];
        return view('admin.user.index',compact('find'));
    }

    public function validatePwd(Request $request)//jquery验证旧密码的正确性
    {
        $date=$request->only(['id','oldPwd']);
        $pwd=$this->admin->where(['id'=>$date['id']])->value('pwd');
        if(Hash::check($date['oldPwd'],$pwd)){
            return $this->ajaxMessage(true,'旧密码输入正确');
        }else{
            return $this->ajaxMessage(false,'旧密码输入错误');
        }
    }

    public function actEditPwd(UserRequest $request)
    {
        $date=$request->input();
        $arr=$this->adminService->getUserInfo();
        $where=['id'=>$arr[1],'mobile'=>$arr[0]];
        $pwd=$this->admin->where($where)->value('pwd');
        if(Hash::check($date['oldPwd'],$pwd)){
            $mod=$this->admin->find($date['id']);
            $mod->pwd=Hash::make($date['newPwd']);
            $res=$mod->save();
            if($res){
                return redirect(url('user/index'))->with('success','修改成功');
//                $request->session()->flush();
            }else{
                return back()->withErrors('修改失败');
            }
        }else{
            return back()->withErrors('旧密码输入有误');
        }
    }

    public function editInfo()//加载修改管理员信息视图
    {
        $arr=$this->adminService->getUserInfo();
        $where=['id'=>$arr[1],'mobile'=>$arr[0]];
        $first=$this->admin->select(['id','name','mobile','pic'])->where($where)->first();
        $mobile = substr($first->mobile, 3, 4);
        $first->mobile = str_replace($mobile, '●●●●', $first->mobile);
        return view('admin.user.editInfo',compact('first'));
    }

    public function actEditInfo(Request $request)//执行修改管理员信息操作
    {
        $date=$request->input();
        $arr=$this->adminService->getUserInfo();
        $where=['id'=>$arr[1],'mobile'=>$arr[0]];
        $flag=$sign=1;
        if(empty($date['name'])&&!empty($date['mobile'])){
            //进行表单验证
            $this->validate($request,[
                'mobile' => array('regex:/^1[34578]\d{9}$/'),
            ],[
                'mobile.regex'=>'管理员账号格式错误',
            ]);
            $data['mobile']=$date['mobile'];
            $flag=2;
        }elseif(!empty($date['name'])&&empty($date['mobile'])){
            $data['name']=$date['name'];
        }elseif(!empty($date['name'])&&!empty($date['mobile'])){
            $data['name']=$date['name'];
            $data['mobile']=$date['mobile'];
            //进行表单验证
            $this->validate($request,[
                'mobile' => array('regex:/^1[34578]\d{9}$/'),
            ],[
                'mobile.regex'=>'管理员账号格式错误',
            ]);
            $flag=2;
        }
        if($request->hasFile('pic')){
            $img=$this->admin->where(['id'=>$arr[1]])->value('pic');
            //拼接文件的名字 和后缀名
            $pathname=time().rand(1000,9999).'.'.$request->file('pic')->getClientOriginalExtension();
            //上传的文件 地址
            $res=$request->file('pic')->move(Config::get('app.uploads_dir'),$pathname);
            if($res){
                $sign=2;
                $data['pic']=trim(Config::get('app.uploads_dir').$pathname,'.');
                
               session(['pic'=>$data['pic']]);
            }else{
                return back()->with('warning','上传管理员头像失败');
            }
        }
        $data['updated_at']=date('Y-m-d H:i:s');
        $res=$this->admin->where($where)->update($data);
        if($res){
            if($flag==2){
                $arr[0]=$date['mobile'];
                $str=implode('-',$arr);
                $info=$this->admin->getEncrypt($str);
                session(['info'=>$info]);
            }
            if($sign==2){
                if($img){
                    unlink('.' . $img);
                }
            }
            return back()->with('success','修改成功');
        }else{
            return back()->withErrors('修改失败');
        }
    }
}
