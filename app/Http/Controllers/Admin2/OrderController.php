<?php

namespace App\Http\Controllers\Admin2;


use Illuminate\Http\Request;
use App\Http\Controllers\PublicController as Controller;
use DB;
use App\Http\Model\Order2 as Order;
use App\Http\Model\Address;
use App\Http\Model\Orderinfo2 as Orderinfo;
use App\Http\Model\Goods2 as Goods;
use Exception;
use App\Events\ActiveLogEvent;

class OrderController extends Controller
{
     protected $orderclass;
  
    public function __construct(Order $orderclass,Orderinfo $orderinfo,Goods $goods)
    {
        $this->orderclass = $orderclass;
        $this->orderinfo = $orderinfo;
        $this->goods = $goods;
    }
  
    #订单列表
    public function index(Request $request){
           
           
            $input=$request->only(['name','phone','start','end','type','status']);
             $query = $this->orderclass->newQuery();

            if($request->has('name'))
                $query->where('name',$input['name']);
            if($request->has('phone')){
                $query->where('phone',$input['phone']);
            }
            if($request->has('start')){
                $start=strtotime($input['start']);
                $query->where('create_at','>=',$start);
            }
             if($request->has('end')){
                $end=strtotime($input['end']);
                $query->where('create_at','<=',$end);
            }
            if($request->has('status')){
                
                $query->where('status',$input['status']);
            }
            if($request->has('type')){
                
                $query->where('type',$input['type']);
            }            
            
        $orderclass = $query->select(['*'])->orderby('id','desc')->paginate(config('admin.pages'));
            foreach ($orderclass as $key => $value) {
                foreach ($orderclass as $k => $v) {
                        if($v['id']==$value['pid']){
                            $orderclass[$key]['pphone']=$v['phone'];
                        }
                }
                  
            }

        $total=$orderclass->total();//总条数

        $page=ceil($total / config('admin.pages'));//共几页
       
        $currentPage=$orderclass->currentPage();//当前页

        return view('admin.order2.index',compact('orderclass','total','page','currentPage'));
    }
    #订单详情
    public function orderinfo(Request $request,$id){
    	//$id=$request->only('id');
    	#查询订单
    	$order=$this->orderclass->where('id',$id)->get();

    	#查询详情
		$info=$this->orderinfo->where('order_id',$id)->get();
			foreach ($info as $key => $value) {
	  			$goodsinfo=$this->goods->where('id',$value['goods_id'])->first();

				$info[$key]['name']=$goodsinfo['name'];
				$info[$key]['pic']=$goodsinfo['pic'];
				
			}
		foreach ($order as $key => $value) {
			$order[$key]['info']=$info;
		}
		
		return view('admin.order2.indexinfo',compact('order','info'));

    }



    public function edit(Request $request ,$id){

        $res=Order::where('id',$id)->first();   

        return view('admin.order2.edit',['res'=>$res]);
    }

    #修改加入物流
    public function editinfo(Request $request){
        $post=$request->input();
        $data=[];
        $data['address']=$post['address'];
        $data['name']=$post['name'];
        $data['phone']=$post['phone'];
        $data['wu']=$post['wu'];
        $data['wuphone']=$post['wuphone'];
        $data['numbers']=$post['numbers'];       
        $data['update_at']=time();
        $data['status']=3;

        $order=Order::where('id',$post['id'])->update($data);
        if($order){
            event(new ActiveLogEvent('执行了发货操作'));
            return back()->with('success','请求成功');   
        }else{
            return back()->withErrors('请求失败'); 
        }
    }

    public static function filterNickname($nickname)
    {
        $pattern = array(
            '/\xEE[\x80-\xBF][\x80-\xBF]/',
            '/\xEF[\x81-\x83][\x80-\xBF]/',
            '/[\x{1F600}-\x{1F64F}]/u',
            '/[\x{1F300}-\x{1F5FF}]/u',
            '/[\x{1F680}-\x{1F6FF}]/u',
            '/[\x{2600}-\x{26FF}]/u',
            '/[\x{2700}-\x{27BF}]/u',
            '/[\x{20E3}]/u'
        );

        $nickname = preg_replace($pattern, '', $nickname);

        return trim($nickname);
    }


    #导出表格
   
    public function export(Request $request)//用户表的导出
    {
       $input=$request->input();

       
       //dump($end);die;
        // $order=Order::get();
    
        // foreach ($order as $key => $value) {
        //          if($value['province']==null) {
        //             dump($value['user_id']);
        //             dump($value['id']);
        //             $address=Address::where(['user_id'=>$value['user_id']])->first();
        //             dump($address);
        //             dump($address['province']);
        //                         $data=[];
        //                         $data['province']=$address['province'];
        //                         $data['city']=$address['city'];
        //                         $data['area']=$address['area'];
        //                         $data['address']=$address['address'];                       
        //                         Order::where(['id'=>$value['id']])->update($data);                             
        //          }                             
        // }      
        // dump(11);die;
        $data=$this->getUserInfo($input);
      
        //dump($data);die;
        $k=0;
        foreach($data as $v){
            foreach($v as $val){
            
                $data1[$k]['id']=$val['id'];
                #过滤字符
                  	$str = $val['name'];
				    $preg = "/[\x{4e00}-\x{9fa5}]+/u";

				    if(preg_match($preg,$str,$matches)){
                        foreach ($matches as $key => $value) {
                            if(empty($value)){
                                $data1[$k]['name']='待确认';
                            }else{
                                $data1[$k]['name']=$value;
                            }
                            
                        }
				        
				    }
              if($val['name']==''){
                    $data1[$k]['name']='待确认';
              }
              	
              	$data1[$k]['goos_name']=$val['goos_name'];
                $data1[$k]['phone']=$val['phone'];
                if($val['type'] == 1){
                    $data1[$k]['type'] = '微信';
                }elseif($val['type'] == 2){
                    $data1[$k]['type'] = '支付宝';
                }elseif($val['type'] == 3){
                    $data1[$k]['type'] = '余额';
                }elseif($val['type']==6){
                    $data1[$k]['type']='系统';
                }else{
                	$data1[$k]['type']='系统';
                }

                if(empty($val['type'])){
                     $data1[$k]['type']='系统';
                }
             
                $data1[$k]['total_money'] = $val['total_money'];
                $data1[$k]['order_num'] = $val['order_num'];

                if($val['status']==1){
                    $data1[$k]['status']='待付款';
                }elseif($val['status']==2){
                    $data1[$k]['status']='待发货';
                }elseif($val['status']==3){
                    $data1[$k]['status']='已发货';
                }elseif($val['status']==4){
                    $data1[$k]['status']='已收货';
                }elseif($val['status']==5){
                    $data1[$k]['status']='交易完成';
                }else{
                    $data1[$k]['status']='待确认';
                } 
                if(empty($val['status'])){
                	$data1[$k]['status']='待确认';
                }

                $data1[$k]['create_at']=date('Y-m-d H:i:s',$val['create_at']);

                if(!empty($val['province'])){
                    $data1[$k]['province']=$val['province'];
                 }else{
                    $data1[$k]['province']='待确认';
                 } 
                 if(!empty($val['city'])){
                    $data1[$k]['city']=$val['city'];
                 }else{
                    $data1[$k]['city']='待确认';
                 } 
                 if(!empty($val['area'])){
                    $data1[$k]['area']=$val['area'];
                 }else{
                    $data1[$k]['area']='待确认';
                 } 
                 if(!empty($val['address'])){
                 	$data1[$k]['address']=$val['address'];
                 }else{
                 	$data1[$k]['address']='待确认';
                 }                                               
                $k++;
            }
        }

        //$data1=array_slice($data1,0,300);
        //$data1=array_slice($data1,1710,90);
        //dump($data1);die;
        $title=array('编号','用户名','商品名称及数量','收货人手机号','支付类型','订单金额','数量','订单状态','创建时间','省','市','区','收货地址');
    
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');
        header('Content-Disposition: attachment;filename='.'订单信息表_'.date('Y-m-d',time()).'.xls');//表格文件名
        header('Content-Transfer-Encoding: binary ');

        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k]=iconv('UTF-8', 'GB2312',$v);//转换编码为utf—8
            }
            $title = implode("\t", $title);//\t空格
            echo $title."\n";//\n为换行//把标题写入表格中
        }
        if (!empty($data)){

            foreach($data1 as $key=>$val){
                foreach ($val as $ck =>$cv) {
                    $data1[$key][$ck]= iconv('UTF-8', 'GBK',$cv);                 
                }
                $data1[$key]=implode("\t", $data1[$key]);
            }
           
            echo implode("\n",$data1);//把数据写入表格中
        }

    }
    public function getUserInfo($input,$first=0,$last=200,&$date=[])
        {

       	$start=strtotime($input['start']);
       	$end=strtotime($input['end']);
       	$status=$input['status'];


       	$query = $this->orderclass->newQuery();
       	 if($start && $end){
                $query->where('create_at','>=',$start);
                $query->where('create_at','<=',$end);
            }

            if($status){
                $query->where('status','=',$status);
            }
    		
            $data=$query->select(['id','name','total_money','phone','type','create_at','status','order_num','province','city','area', 'address'])->skip($first)->take($last)->orderby('id','desc')->get();
            $arr=[];
            foreach ($data as $k => $v) {
            	$orderinfo=$this->orderinfo->where('order_id',$v['id'])->get();
            	

	            	foreach ($orderinfo as $key => $value) {
	            			$data[$k]['goos_name']=$value['name'].','.$value['num'];
	            			
	            	}           	
            }
          
            if(count($data) > 0){
                $first=$first+200;
                $date[]=$data;
                $this->getUserInfo($input,$first,200,$date);
            }
            return $date;
        }
        
   
  

}
