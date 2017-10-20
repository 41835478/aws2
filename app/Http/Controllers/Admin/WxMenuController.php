<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use DB;

class WxMenuController extends Controller
{
    protected $menu;

    public function __construct(Menu $menu)
    {
        $this->menu=$menu;
    }

    public function index()
    {
        return view('admin.menu.index');
    }

    public function actNav(Request $request)//执行添加微信一级菜单操作
    {
        $this->validate($request,[
            'name'=>'required',
            'sort'=>'required',
        ],[
            'name.required'=>'一级菜单名称不能为空',
            'sort.required'=>'排序不能为空',
        ]);
        $date=$request->except('_token');
        $res=$this->menu->insert($date);
        if($res){
            return back()->with('success','添加一级菜单成功');
        }else{
            return back()->withErrors('添加失败');
        }
    }

    public function nav()//加载添加二级微信菜单视图
    {
        $date=$this->menu->where(['parent_id'=>0])->get(['name','id']);
        return view('admin.menu.nav',['data'=>$date]);
    }

    public function addMenu(Request $request)//添加微信二级菜单
    {
        $this->validate($request,[
            'name'=>'required',
            'type'=>'required',
        ],[
            'name.required'=>'一级菜单名称不能为空',
            'type.required'=>'响应类型不能为空',
        ]);
        $date=$request->except('_token');
        if (empty($date['twoName'])) {
            $data['type'] = $date['type'];
            $data['url'] = $date['url'];
            $data['key'] = $date['key'];
            $res = $this->menu->where(['id'=>$date['name']])->update($data);
        } else {
            $data['name'] = trim($date['twoName']);
            $data['type'] = $date['type'];
            $data['parent_id'] = $date['name'];
            $data['url'] = $date['url'];
            $data['key'] = $date['key'];
            $data['path'] = '0,' . $date['name'];
            $res = $this->menu->insert($data);
        }
        if ($res) {
            return back()->with('success','添加成功');
        }
        return back()->withErrors('添加失败');
    }

    public function menuList()//微信菜单列表
    {
        $date=$this->menu->select(DB::raw('*,concat(path,",",id) as paths'))->orderBy('paths')->get();
        $data=array();
        if($date){
            foreach ($date as $k => $v) {
                $list = explode(',', $v['paths']);
                $count = count($list) - 2;
                $data[$k]['id']=$v['id'];
                $data[$k]['sort']=$v['sort'];
                $data[$k]['parent_id']=$v['parent_id'];
                $data[$k]['type']=$v['type'];
                $data[$k]['key']=$v['key'];
                $data[$k]['name'] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $count) . $v['name'];
                $data[$k]['url']=$v['url'];
            }
        }
        return view('admin.menu.menuList',['date'=>$data]);
    }

    public function editFirstNav()//加载修改一级菜单视图
    {
        $date = $this->menu->where(['parent_id' => 0])->get(['id', 'name']);
        return view('admin.menu.editFirstNav',['data'=>$date]);
    }

    public function actEditNav(Request $request)//执行一级菜单的修改
    {
        $this->validate($request,[
            'name'=>'required',
            'newName'=>'required',
        ],[
            'name.required'=>'一级菜单名称不能为空',
            'newName.required'=>'新的一级菜单名称不能为空',
        ]);
        $date =$request->except('_token');
        $mod = $this->menu;
        $id = intval($date['name']);
        $data['name'] = $date['newName'];
        $data['update_at'] = time();
        $res = $mod->where(['id' => $id])->update($data);
        if ($res) {
            return back()->with('success','修改成功');
        }
        return back()->withErrors('修改失败');
    }

    public function menuEdit($id)//菜单列表中的修改操作
    {
        $mod = $this->menu;
        $name = array();
        if ($id) {
            $pid = $mod->where(['id' => $id])->first(['parent_id']);
            if ($pid->parent_id == 0) {
                $res = $mod->where(['id' => $id])->first(['id', 'name', 'type', 'key', 'url']);
                if (!empty($res->type) && ($res->type == 1)) {
                    $res->typeName = 'click';
                } elseif (!empty($res->type) && ($res->type == 2)) {
                    $res->typeName = 'view';
                } else {
                    $res->typeName = '--请选择--';
                    $res->type = '';
                }
                $num=1;
            } else {
                $name = $mod->where(['id' => $pid->parent_id])->first(['name', 'id']);
                $res = $mod->where(['id' => $id])->first(['id', 'name', 'type', 'key', 'url']);
                if ($res->type == 1) {
                    $res->typeName = 'click';
                } else {
                    $res->typeName = 'view';
                }
                $num=2;
            }
            $date = $mod->where(['parent_id' => 0])->get(['id', 'name']);
            return view('admin.menu.menuEdit',compact('name','date','res','num'));
        } else {
            return back()->withErrors('非法请求');
        }
    }

    public function actEditMenu(Request $request)//执行修改菜单链接
    {
        $this->validate($request,[
            'name'=>'required',
        ],[
            'name.required'=>'一级菜单名称不能为空',
        ]);
        $date = $request->except('_token');
        $mod = $this->menu;
        if (empty($date['twoName'])) {
            $data['type'] = $date['type'];
            $data['url'] = $date['url'];
            $data['key'] = $date['key'];
            $data['update_at'] = time();
            $res = $mod->where(['id' => $date['id']])->update($data);
        } else {
            $data['name'] = $date['twoName'];
            $data['type'] = $date['type'];
            $data['parent_id'] = $date['name'];
            $data['url'] = $date['url'];
            $data['key'] = $date['key'];
            $data['path'] = '0,' . $date['name'];
            $data['update_at'] = time();
            $res = $mod->where(['id' => $date['id']])->update($data);
        }
        if ($res) {
            return back()->with('success','修改成功');
        }
        return back()->withErrors('修改失败');
    }

    public function sort(Request $request)//微信菜单列表中的排序操作
    {
        $date=$request->except('_token');
        $data['update_at']=time();
        $data['sort']=$date['sort'];
        $res=$this->menu->where(['id'=>$date['id']])->update($data);
        if($res){
            return $this->ajaxMessage(true,'设置成功');
        }else{
            return $this->ajaxMessage(false,'设置失败');
        }
    }

    public function menuDel(Request $request)//菜单列表中的删除操作
    {
        $id=$request->only('id')['id'];
        $mod=$this->menu;
        $res=$mod->where(['parent_id'=>$id])->first();
        if($res){
            return $this->ajaxMessage(false,'请先删除其子类');
        }else{
            $res1=$mod->where(['id'=>$id])->delete();
            if($res1){
                return $this->ajaxMessage(true,'删除成功');
            }else{
                return $this->ajaxMessage(false,'删除失败');
            }
        }
    }
}
