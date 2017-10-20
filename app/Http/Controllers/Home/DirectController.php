<?php

namespace App\Http\Controllers\Home;

use App\Http\Services\DirectService;
use App\Http\Services\RowAService;
use App\Http\Services\RowService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DirectController extends Controller
{
    protected $row;
    protected $directService;
    protected $rowAService;

    public function __construct(RowService $row,DirectService $directService,RowAService $rowAService)
    {
        $this->row=$row;
        $this->directService=$directService;
        $this->rowAService=$rowAService;
    }

    //$order_id 订单id   $type 1、爱无尚商城 2、合作平台 3、100元专区 4、300元专区 5、2000元专区
    public function index(Request $request)
    {
        $order_id=$request->input('order_id');
        $type=$request->input('type');
//        $order_id=12;
//        $type=3;
        if($type==1||$type==2){//要进行分佣
            $this->directService->main(1);
        }elseif($type==3||$type==4||$type==5){//要进行排位
            $res=$this->row->index($order_id);
//            if($res){
//                dd($this->rowAService->index($res));
//            }
//            event(new RowEvent($order_id,$type));
        }
    }
}
