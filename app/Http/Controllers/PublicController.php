<?php

namespace App\Http\Controllers;

use App\Http\Model\Goodsclass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function ajaxMessage($status, $errorMessage = '', $data = '')
    {
        $result = [
            'status' => $status,
            'message' => $errorMessage,
            'data' => $data
        ];
        return response()->json($result);
    }

    /**
     * @param $request  请求
     * @param $path  文件存放路径
     * @param $pic 提交的文件名
     * @return bool|string
     */
    public function uploadsFile($request,$path,$pic)//文件上传
    {
        $file=$request->file($pic);
        $extensions = ['jpeg','jpg','gif','gpeg','png'];
        if($file->isValid()){
            $ext=$file->getClientOriginalExtension();
            if(in_array(strtolower($ext),$extensions)){
                $fileName=date('YmdHis').'-'.uniqid().'.'.$ext;
                if($file->move($path,$fileName)){
                    return $path.'/'.$fileName;
                }
            }
        }
        return false;
    }

    /**
     * @param $object  当前查询数据对象
     * @return mixed  返回分页的信息
     */
    public function paging($object)
    {
        $res['total']=$object->total();//总条数
        $res['page']=ceil($res['total']/config('admin.pages'));//共几页
        $res['currentPage']=$object->currentPage();//当前页
        return $res;
    }

    public function goodsClass($data)//得到商品分类（如一级，二级，三级等）
    {
        if(isset($data['type'])){
            return Goodsclass::select(['id','pid','name'])->where(['pid'=>0,'type'=>$data['type']])->get();
        }else{
            return $this->common($data['id']);
        }
    }

    public function common($pid = 0, &$result = array())//用于处理分类的公共方法
    {
        $res = Goodsclass::select(['name', 'id', 'pid', 'path'])->where(['pid' => $pid])->get();
        foreach ($res as $v) {
            $count = (count(explode(',', $v['path'])) - 2) * 2;
            $name = str_repeat('&nbsp;&nbsp;&nbsp;', $count) . $v['name'];
            $data['name'] = $name;
            $data['id'] = $v['id'];
            $result[] = $data;
            $this->common($v['id'], $result);
        }
        return $result;
    }

    /**
     * @param $pid
     * @return \Illuminate\Database\Eloquent\Model|null|static  返回对象
     */
    public function getOneGoodsClass($pid)//得到商品分类的顶级分类
    {
        $res=Goodsclass::where(['id'=>$pid])->first(['pid','id','name']);
        if($res->pid){
            return $this->getOneGoodsClass($res->pid);
        }
        return $res;
    }

}
