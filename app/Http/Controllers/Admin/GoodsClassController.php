<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Goodsclass;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use DB;
use Exception;

class GoodsClassController extends Controller
{
    protected $goodsClass;

    public function __construct(Goodsclass $goodsclass)
    {
        $this->goodsClass = $goodsclass;
    }

    public function index()//加载商品分类视图
    {
        $res = $this->common();
        return view('admin.goodsClass.index', compact('res'));
    }

    public function addClass(Request $request)//添加商品分类
    {
        $this->validate($request, [
            'name' => 'required',
            'type'=>'required'
        ], [
            'name.required' => '商品分类名称不能为空',
            'type.required'=>'分类类型为必选项'
        ]);
        $date = $request->input();
        $pic = '';
        if ($request->hasFile('pic')) {
            $path = $this->uploadsFile($request, 'uploads/goodsClass', 'pic');
            if ($path) {
                $pic = $path;
            } else {
                return back()->withErrors('上传分类图片失败');
            }
        }
        $data = $this->judgeTopClass($date['top']);
        $data['type']=$date['type'];
        $data['pic'] = $pic ? $pic : '';
        $data['name'] = trim($date['name']);
        $res = Goodsclass::create($data);
        if ($res) {
            return back()->with('success', '添加分类成功');
        } else {
            return back()->with('error', '添加分类失败');
        }
    }

    protected function judgeTopClass($top)//用于判断是否为顶级分类
    {
        if (!empty($top)) {
            $find = $this->goodsClass->select(['pid', 'path', 'id'])->where(['id' => $top])->first();
            $data['pid'] = $top;
            $data['path'] = $find['path'] . ',' . $find['id'];
        } else {
            $data['pid'] = 0;
        }
        return $data;
    }

    public function common($pid = 0, &$result = array())//用于处理分类的公共方法
    {
        $res = $this->goodsClass->select(['name', 'id', 'pid', 'path'])->where(['pid' => $pid])->get();
        foreach ($res as $v) {
            if ($v['pid'] != 0) {
                $count = (count(explode(',', $v['path'])) - 1) * 2;
                $name = str_repeat('&nbsp;&nbsp;&nbsp;', $count) . $v['name'];
            } else {
                $name = $v['name'];
            }
            $data['name'] = $name;
            $data['id'] = $v['id'];
            $result[] = $data;
            $this->common($v['id'], $result);
        }
        return $result;
    }

    public function goodsList(Request $request)//商品分类列表视图
    {
        $input=$request->only(['topName','secondName','type']);
        $query = $this->goodsClass->newQuery();
        if($request->has('type')){
            $query->where('type',$input['type']);
        }
        if($request->has('secondName'))
            $query->where('id',$input['secondName'])->orWhere('pid',$input['secondName']);
        if($request->has('topName'))
            $query->where('id',$input['topName'])->orWhere('pid',$input['topName']);
        $goodsClass = $query->select(DB::raw('*,concat(path,",",id) as paths'))
            ->orderBy('paths')->paginate(config('admin.pages'));
        foreach ($goodsClass as $k => $v) {
            $count = (count(explode(',', $v->paths)) - 2) * 2;
            if ($v->pid == 0) {
                $name = $v->name;
            } else {
                $name = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $count) . $v->name;
            }
            $data[$k]['name'] = $name;
            $data[$k]['sort'] = $v->sort;
            $data[$k]['id'] = $v->id;
            $data[$k]['pic'] = $v->pic;
            $data[$k]['type'] = $v->type;
            $data[$k]['status'] = $v->status;
            $data[$k]['create_at'] = date('Y-m-d H:i',$v->create_at);
            $data[$k]['update_at'] = date('Y-m-d H:i',$v->update_at);
        }
        $date=$this->goodsClass->select(['id','name'])->where(['pid'=>0])->get();
        $total=$goodsClass->total();//总条数
        $page=ceil($total/config('admin.pages'));//共几页
        $currentPage=$goodsClass->currentPage();//当前页
        return view('admin.goodsClass.goodsList',compact('date','goodsClass','data','total','page','currentPage'));
    }

    public function editClass($id)//加载商品列表中的修改视图
    {
        $res = $this->common();
        $first=$this->goodsClass->where(['id'=>$id])->first();
        return view('admin.goodsClass.editClass',['res'=>$first,'data'=>$res]);
    }

    public function actEditClass(Request $request)//执行商品分类修改操作
    {
        $date = $request->input();
        $mod = $this->goodsClass;
        if (!empty($date['top'])) {//说明是选择了上级
            $res1 = $mod->select(['path'])->where(['id' => $date['top']])->first();//拿到上级的信息
            $data['pid']=$date['top'];
            $data['path']=$res1['path'].','.$date['top'];
            $pid=$date['id'];
        } else {//没有选择上级
            $data['path']=0;
            $data['pid']=0;
            $pid=$date['id'];
        }
        $flag1=0;
        if ($request->hasFile('pic')) {
            $pic=$mod->where(['id'=>$date['id']])->value('pic');
            $path = $this->uploadsFile($request, 'uploads/goodsClass', 'pic');
            if ($path) {
                $flag1=1;
                $data['pic'] = $path;
            } else {
                return back()->withErrors('上传分类图片失败');
            }
        }
        $data['type']=$date['type'];
        $data['name']=$date['name'];
        $data['update_at']=time();
        $res=$mod->where(['id'=>$date['id']])->update($data);
        if($res){
            $val=$this->installPath($mod,$pid,$data['path']);
            if($val){
                if($flag1==1){
                    unlink('./'.$pic);
                }
                return back()->with('success','修改商品分类成功');
            }else{
                return back()->withErrors('修改商品分类失败');
            }
        }else{
            return back()->withErrors('修改商品分类失败');
        }
    }

    public function installPath($mod,$pid,$path)//用于拼装path路径
    {
        $res=$mod->select(['id','path','pid'])->where(['pid'=>$pid])->get();
        if(count($res)>0&&is_array($res)&&!empty($res)){
            $date=array();
            foreach($res as $v){
                $path2=$path.','.$pid;
                $date['pid']=$pid;
                $date['path']=$path2;
                $date['update_at']=time();
                $res1=$mod->where(['id'=>$v['id']])->update($date);
                if($res1){
                    $path1=$path2;
                    $this->installPath($mod,$v['id'],$path1);
                }else{
                    return false;
                }
            }
            return true;
        }else{
            return true;
        }
    }

    public function whetherDisplay(Request $request)//商品分类列表中的显示不显示操作
    {
        $date = $request->except('_token');
        $mod = $this->goodsClass;
        if ($date['flag'] == 1) {
            $data['status'] = 1;
        } else {
            $data['status'] = 2;
        }
        $data['update_at'] = time();
        DB::beginTransaction();
        try {
            $res = $mod->where(['id' => $date['id']])->update($data);
            if ($res) {
                $res2 = $this->allDisplay($mod,$date['id'], $date['flag']);
                if ($res2) {
                    DB::commit();
                    return $this->ajaxMessage(true,'设置成功');
                } else {
                    throw new \Exception();
                }
            } else {
                throw new Exception();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->ajaxMessage(false,'设置失败');
        }
    }

    public function allDisplay($mod,$id, $flag)//当点击不显示或者显示时让其所有子类都显示或不显示(该功能属于附加功能)
    {
        $date = $mod->select(['id'])->where(['pid' => $id])->get();
        if ($date) {
            foreach ($date as $v) {
                $data['update_at'] = time();
                if ($flag == 1) {
                    $data['status'] = 1;
                } else {
                    $data['status'] = 2;
                }
                $res = $mod->where(['id' => $v['id']])->update($data);
                if ($res) {
                    $this->allDisplay($mod,$v['id'], $flag);
                } else {
                    return false;
                }
            }
        }
        return true;
    }

    public function sort(Request $request)//排序操作
    {
        $date = $request->only(['id','sort']);
        $date['update_at'] = time();
        $data['sort'] = $date['sort'];
        $res = $this->goodsClass->where(['id' => $date['id']])->update($data);
        if ($res) {
            return $this->ajaxMessage(true,'设置成功');
        } else {
            return $this->ajaxMessage(false, '设置失败');
        }
    }

    public function goodsClassDel(Request $request)//商品分类列表中的删除操作
    {
        $id = $request->only('id')['id'];
        $find = $this->goodsClass->where(['pid'=>$id])->first();
        if ($find) {
            return $this->ajaxMessage(false,'该分类下有子类请先删除其子类');
        } else {
            $mod=$this->goodsClass->find($id);
            $pic=$mod->pic;
            $res = $this->goodsClass->where(['id' => $id])->delete();
            if ($res) {
                if($pic){
                    unlink('./'.$pic);
                }
                return $this->ajaxMessage(true,'删除成功');
            } else {
                return $this->ajaxMessage(false,'删除失败');
            }
        }
    }

    public function secondClass(Request $request)//通过一级分类得到二级分类(或通过二级分类的到三级分类)
    {
        $id=$request->only('id');
        $date=$this->goodsClass->select(['id','name'])->where(['pid'=>$id])->get();
        if($date){
            return $this->ajaxMessage(true,'获取分类成功',$date);
        }else{
            return $this->ajaxMessage(false,'获取分类失败',$date);
        }
    }
}
