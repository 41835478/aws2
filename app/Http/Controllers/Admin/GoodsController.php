<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Goods;
use App\Http\Model\Goodsclass;
use App\Http\Requests\Admin\GoodsAreaRequest;
use App\Http\Requests\Admin\GoodsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use Illuminate\Support\Facades\Input;

class GoodsController extends Controller
{
    protected $goods;

    public function __construct(Goods $goods)
    {
        $this->goods=$goods;
    }

    public function index($mark=1)//加载添加商品视图
    {
        $flag=$mark;
        return view('admin.goods.index',compact('flag'));
    }

    public function getGoodsClass(Request $request)//获取商品分类
    {
        $data='';
        $date=$request->only(['type','id']);
        $data=$this->goodsClass($date);
        return $this->ajaxMessage(true,'获取数据成功',$data);
    }

    public function addGoods(GoodsRequest $request)//执行添加商品操作
    {
        $date=$request->except(['_token','pic','small_pic']);
        $res=$this->goodsCommon($date,$request,1);
        if ($res) {
            return redirect(url('goods/index',array('mark'=>1)))->with('success','添加商品成功');
        } else {
            return back()->with('error','添加商品失败');
        }
    }

    public function actGoodsArea(GoodsAreaRequest $request)//执行添加专区商品操作
    {
        $date=$request->except(['_token','pic','small_pic']);
        $res=$this->goodsCommon($date,$request,2);
        if ($res) {
            return redirect(url('goods/index',array('mark'=>2)))->with('success','添加商品成功');
        } else {
            return back()->with('error','添加商品失败');
        }
    }

    public function goodsCommon($date,$request,$flag)//添加商品公共函数
    {
        $mod = $this->goods;
        $data=array();
        if($flag==1){
            if($request->has('goodsType')){
                foreach($date['goodsType'] as $v){
                    if($v==1){
                        $data['hots']=1;
                    }
                    if($v==2){
                        $data['sales_push']=1;
                    }
                }
                unset($date['goodsType']);
            }
        }else{
            if($date['goodsArea']==4){
                $data['price']=100;
            }
            if($date['goodsArea']==5){
                $data['price']=300;
            }
            if($date['goodsArea']==6){
                $data['price']=2000;
            }
            $data['type']=$date['goodsArea'];
            unset($date['goodsArea']);
        }
        foreach($date as $k=>$v){
            $data[$k]=$v;
        }
        if($request->hasFile('pic')){
            $path = $this->uploadsFile($request, 'uploads/goods/main_pic', 'pic');
            if ($path) {
                $data['pic'] = $path;
            } else {
                return back()->withErrors('上传商品主图失败');
            }
        }else{
            return back()->withErrors('请上传商品主图');
        }
        if($request->hasFile('small_pic')){
            $files=$request->file('small_pic');
            foreach($files as $file){
                $ext=$file->getClientOriginalExtension();
                $fileName=date('YmdHis').'-'.uniqid().'.'.$ext;
                if($file->move('uploads/goods/small_pic',$fileName)){
                    $arr[]='uploads/goods/small_pic/'.$fileName;
                }else{
                    return back()->withErrors('上传商品轮播图失败');
                }
            }
            $data['small_pic']=json_encode($arr);
        }else{
            return back()->withErrors('请上传商品轮播图');
        }
        $data['create_at']=time();
        $res=$mod->insert($data);
        if ($res) {
            return true;
        }
        return false;
    }

    public function goodsList(Request $request)//加载商品列表视图
    {
        $date=$this->goods->whereIn('type',[1,2,3])->where(function($query) use ($request){
            if($request->has('name'))
                $query->orWhere('name','like','%'.$request->input('name').'%');
            if($request->has('goodsType')){
                $goodsType=Input::get('goodsType');
                if($goodsType==1){//说明是热门推荐
                    $query->orWhere(['hots'=>$goodsType]);
                }else{
                    $query->orWhere(['sales_push'=>$goodsType]);
                }
            }
            if($request->has('classType'))
                $query->orWhere(['type'=>$request->input('classType')]);
            if($request->has('nextName'))
                $query->orWhere(['class_id'=>Input::get('nextName')]);
        })->paginate(config('admin.pages'));

        foreach($date->items() as $k=>$v){
            $date->items()[$k]['class_name']=$this->getClass($v['class_id'])?$this->getClass($v['class_id']):'';
            $date->items()[$k]['small_pic']=json_decode($v['small_pic'],true);
        }
        $goodsClass=Goodsclass::select(['id','name'])->where(['pid'=>0])->get();
        $res=$this->paging($date);//分页信息
        return view('admin.goods.goodsList',compact('date','res','goodsClass'));
    }

    public function getClass($id)
    {
        $find=Goodsclass::find($id);
        return $find->name;
    }

    public function goodsAreaList(Request $request)//加载专区商品列表
    {
        $query=$this->goods->newQuery();
        if($request->has('areaType'))
            $query->where(['type'=>$request->input('areaType')]);
        if($request->has('name'))
            $query->where('name','like','%'.$request->input('name').'%');
        $date=$query->select(['id','name','pic','small_pic','title','money','price','storage','sale','status','content','factory_code'])
            ->whereIn('type',[4,5,6])->paginate(config('admin.pages'));
        foreach($date->items() as $k=>$v){
            $date->items()[$k]['small_pic']=json_decode($v['small_pic'],true);
        }
        $res=$this->paging($date);
        return view('admin.goods.goodsAreaList',compact('date','res'));
    }

    public function goodsEdit($id)//加载商城商品修改视图
    {
        $res=Goods::select(['id','name','class_id','title','pic','price','money','integral','storage','sale','type','factory_code'])
            ->where(['id'=>$id])->first();
        if($res->type!=3)
            $res->class_name=$this->getClassName($res->class_id);
        $goodsClass=Goodsclass::where(['id'=>$res->class_id])->first(['pid','id','name']);
        if($goodsClass->pid){
            $class=$this->getOneGoodsClass($goodsClass->pid);
            $data['id']=$class->id;
            $data['name']=$class->name;
        }else{
            $data['id']=$goodsClass->id;
            $data['name']=$goodsClass->name;
        }
        return view('admin.goods.goodsEdit',compact('id','res','data'));
    }

    public function actEditGoods(GoodsRequest $request)//执行商城商品的修改操作
    {
        $date = $request->except(['_token','pic']);
        $res=$this->goodsEditCommon($date,$request,1);
        if($res){
            return back()->with('success','修改商品成功');
        }
        return back()->withErrors('修改商品失败');
    }

    public function goodsAreaEdit($id)//加载专区商品修改视图
    {
        $res=Goods::select(['id','name','title','pic','storage','sale','type','factory_code'])
            ->where(['id'=>$id])->first();
        return view('admin.goods.goodsAreaEdit',['res'=>$res,'id'=>$id]);
    }

    public function actEditAreaGoods(GoodsAreaRequest $request)
    {
        $date = $request->except(['_token','pic']);
        $res=$this->goodsEditCommon($date,$request,2);
        if($res){
            return back()->with('success','修改商品成功');
        }
        return back()->withErrors('修改商品失败');
    }

    public function goodsEditCommon($date,$request,$mark)
    {
        $mod = $this->goods;
        $flag=1;
        if($mark==2){
            $data['type']=$date['goodsArea'];
            unset($date['goodsArea']);
        }
        if($request->hasFile('pic')){
            $path = $this->uploadsFile($request, 'uploads/goods/main_pic', 'pic');
            $img=$mod->where(['id'=>$date['id']])->value('pic');
            if ($path) {
                $flag=2;
                $data['pic'] = $path;
            } else {
                return back()->withErrors('上传商品主图失败');
            }
        }
        foreach($date as $k=>$v){
            $data[$k]=$v;
        }
        $data['update_at']=time();
        $res = $mod->where(['id'=>$date['id']])->update($data);
        if ($res) {
            if($flag==2){
                unlink('./'.$img);
            }
            return true;
        }
        return false;
    }

    public function getClassName($id)//获取分类的名称
    {
        $res = Goodsclass::where(['id' => $id])->value('name');
        if ($res) {
            return $res;
        }
        return '';
    }

    public function editGoodsInfo(Request $request)//修改商品列表中的商品详情
    {
        if($request->has('content')){
            $goods=Goods::find($request->input('id'));
            $goods->content=$request->input('content');
            if($goods->save()){
                return back()->with('success','修改商品详情成功');
            }
            return back()->withErrors('修改失败');
        }
        return back()->withErrors('修改商品详情的信息为空');
    }

    public function smallPicEdit($id,$flag)//加载修改商品轮播图的视图
    {
        $res=Goods::where(['id'=>$id])->value('small_pic');
        $data=array();
        if($res){
            $data=json_decode($res,true);
        }
        return view('admin.goods.smallPicEdit',compact('id','data','flag'));
    }

    public function editSmallPic(Request $request)//执行修改商品列表中的修改轮播图操作
    {
        $this->validate($request,[
            'small_pic'=>'required',
        ],[
            'small_pic.required'=>'上传文件不能为空',
        ]);
        $mod=$this->goods;
        $pic=$mod->where(['id'=>$request->input('id')])->value('small_pic');
        $path = $this->uploadsFile($request, 'uploads/goods/small_pic', 'small_pic');
        if ($path) {
            if(!empty($pic)){
                $img=json_decode($pic,true);
                array_push($img,$path);
                $data['small_pic']=json_encode($img);
            }else{
                $imgs[]=$path;
                $data['small_pic']=json_encode($imgs);
            }
        } else {
            return back()->withErrors('上传商品轮播图失败');
        }
        $data['update_at']=time();
        $res=$mod->where(['id'=>$request->input('id')])->update($data);
        if($res){
            return back()->with('success','添加商品轮播图成功');
        }else{
            return back()->withErrors('添加商品轮播图失败');
        }
    }

    public function delSmallPic(Request $request)//执行修改商品轮播图的删除操作
    {
        $date=$request->only(['id','pic']);
        $mod=$this->goods;
        $small_pic=$mod->where(['id'=>$date['id']])->value('small_pic');
        $pic=json_decode($small_pic,true);
        foreach($pic as $k=>$v){
            if($v==$date['pic']){
                array_splice($pic,$k,1);
            }
        }
        if(count($pic)>0){
            sort($pic);
            $attr['small_pic']=json_encode($pic);
        }else{
            $attr['small_pic']='';
        }
        $attr['update_at']=time();
        $res=$mod->where(['id'=>$date['id']])->update($attr);
        if($res){
            unlink('./'.$date['pic']);
            return $this->ajaxMessage(true,'删除成功');
        }else{
            return $this->ajaxMessage(true,'删除失败');
        }
    }

    public function goodsDel(Request $request)//商城商品列表中的删除操作
    {
        $id=$request->only('id')['id'];
        $res=Goods::where(['id'=>$id])->delete();
        if($res){
            return $this->ajaxMessage(true,'删除成功');
        }
        return $this->ajaxMessage(true,'删除失败');
    }

    public function commonSet(Request $request)//商品列表中的公共设置
    {
        $date=$request->only(['id','flag','mark']);
        $mod=$this->goods->find($date['id']);
        if($date['mark']==1){//说明是设置上架下架
            if($date['flag']==1){//说明是
                $mod->status=1;
            }else{
                $mod->status=2;
            }
        }
        if($date['mark']==2){//说明是热门推荐
            if($date['flag']==1){//说明是
                $mod->hots=1;
            }else{
                $mod->hots=2;
            }
        }
        if($date['mark']==3){//说明是促销活动
            if($date['flag']==1){//说明是
                $mod->sales_push=1;
            }else{
                $mod->sales_push=2;
            }
        }
        $res=$mod->save();
        if($res){
            return $this->ajaxMessage(true,'设置成功');
        }
        return $this->ajaxMessage(false,'设置失败');
    }

    public function getInputForm(Request $request)//获取input表单
    {
        $flag=$request->input('type');
        if($flag==3){//说明是积分商城
            $str=<<<Fol
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品消费积分</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="integral" value="">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>               
Fol;
        }else{
            $str=<<<Eol
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品价格</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="price" value="">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品市场价</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="money" value="">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

Eol;
        }
        return $this->ajaxMessage(true,'获取数据成功',$str);
    }
}
