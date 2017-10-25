<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Model\User;
use App\Http\Model\Pointsrecode;
use App\Http\Model\Promoterecode;
use App\Http\Model\Incomerecode;
use App\Http\Model\Withdraw;
use App\Http\Model\Payment;
use App\Http\Model\Roworder;
use App\Http\Model\Address;
use App\Http\Model\Order;
use App\Http\Model\Orderinfo;
use App\Http\Model\Goods;
use App\Http\Model\Promoteinfo;
use App\Http\Controllers\Home\BaseController;
use Illuminate\Http\RedirectResponse;
use App\Http\Services\RowCommonService;
use Storage;
use DB;

use Cache;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Http\Services\AuthService;
use App\Http\Services\SendCodeService;
use App\Events\AcoutEvent;

class UserController  extends BaseController
{

    protected $auth;
    protected $msg;
    protected $rowCommonService;

    public function __construct(AuthService $auth,SendCodeService $msg,RowCommonService $rowCommonService)
    {
        parent::__construct($auth,$msg);
        $this->rowCommonService=$rowCommonService;
    }
    #余额记录
    public function balance(){
        $uid=$this->checkUser();
        $roworders=DB::table('balance')->where('user_id',$uid)->orderBy('id','DESC')->get();

        return view('home.user.balance',compact('roworders'));
    }

	#二维码
	public function qrcode(){

        $uid=$this->checkUser();
        $t = new User;
        $users = $t->getuserinfo($uid); 
        if (mb_strlen($users->name,'utf8') <=3) {
            $users->name = '　 '.$users->name;
        }
        if($users['level'] != 1){
        	 return redirect('users/index');
        }                       
        return view('home.user.Qrcode_new',compact('users'));
	}

    public function createqrcode1(){
        $uid=$this->checkUser(); 
        ob_clean();  

       //   header("Access-Control-Allow-Origin: www.tjzbdkj.com");

        include base_path()."/phpqrcode.php";  
        $object = new \ QRcode();
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/register/index1/'.$uid;//网址或者是文本内容
        $level=3;
        $size=4;
        $errorCorrectionLevel =intval($level) ;//容错级别
        $matrixPointSize = intval($size);//生成图片大小       
         $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2); 

        DIE();
   
    }


    public function createqrcode(){
        $uid=$this->checkUser(); 
        ob_clean();  

       //	header("Access-Control-Allow-Origin: www.tjzbdkj.com");

        include base_path()."/phpqrcode.php";  
        $object = new \ QRcode();
        $url = 'http://'.$_SERVER['HTTP_HOST'].'/register/index/'.$uid;//网址或者是文本内容
        $level=3;
        $size=4;
        $errorCorrectionLevel =intval($level) ;//容错级别
        $matrixPointSize = intval($size);//生成图片大小       
         $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2); 

        DIE();
    }







    #绑定微信
    public function bingwx(){
        $uid=$this->checkUser();
        $t = new User;
        $users = $t->getuserinfo($uid);  
        if($users['level'] != 1){
             return redirect('users/index');
        }                       
 
        return view('home.user.bingwx',compact('users'));
    }
    

    public function index()//页面
    {
//    	#查询用户信息
    	$uid=$this->checkUser();
    	$t = new User;
    	$users=$t->getuserinfo($uid);
    	#查询上级
        $pusers=$t->getuserinfo($users['pid']);
    	#查询团队
     	$teamm=self::allcount([$uid],0,[]);  #

        $countt=count($teamm);
        // if($users['mynumcount']== ''){
        //     event(new AcoutEvent($uid));
        // }

        $love = DB::table('order2')->where(['user_id'=>$uid])->where('status','>=','2')->sum('total_money');    

        return view('home.user.index',compact('users','pusers','countt','love'));
    }


    public static function allcount($id,$num,$userId)
    {
         if ($num == 20) {
           return $userId;
         }
        $ids = User::whereIn('pid',$id)->pluck('id');
        if (count($ids) < 1) {
            return $userId;
        }
        $userId =array_merge_recursive($userId,$ids ->toArray()); //查询全部
        //$userId[$num] = $ids ->toArray(); //查询一个等级级
        $num ++ ;
        return self::allcount($ids,$num,$userId);
    }

  
	
    #修改资料
    public function editdata(){
        #查询用户信息 
        $uid=$this->checkUser();
        $t = new User;
        $users=$t->getuserinfo($uid);
        return view('home.user.editdata',compact('users'));
    }

        public function editdatainfo(Request $request){
            #查询用户信息 
            $uid=$this->checkUser();
            $post=$request->input();
            $data=[];
            $data['name']=$post['name'];
            $data['login_name']=$post['login_name'];
            $data['sex']=$post['sex'];
            if($post['pic'] != ''){
                $data['pic']=$post['pic'];
            }
            
            $res=User::where('id',$uid)->update($data);
            if($res){
                return $this->ajaxMessage(true,'操作成功',['flag'=>1]);
             }else{
                return $this->ajaxMessage(false,'操作失败');
             }

        }








/***
*账户信息
*
****/
    #我的账户
    public function myaccount(){
    	$uid=$this->checkUser();
    	$t = new User;
    	$users=$t->getuserinfo($uid);

    	$saccount=Incomerecode::where('user_id',$uid)->where('flag',1)->orderBy('id','DESC')->get();
    	$zaccount=Incomerecode::where('user_id',$uid)->where('flag',2)->orderBy('id','DESC')->get();
        foreach ($zaccount as $key => $value) {        	 
        	$zaccount[$key]['pphone']=User::where('id',$value['from_id'])->value('phone');
        }
        //dump($zaccount);die; 
    	return view('home.user.myaccount',compact('users','saccount','zaccount'));
    }
     #余额转账
    public function turnaccount(){
    	$uid=$this->checkUser();
    	$t = new User;
    	$users=$t->getuserinfo($uid);

    	return view('home.user.turnaccount',compact('users'));
    }
    	#选择银行卡
    public function choosebnak(){
    	$uid=$this->checkUser();
    	$t = new User;
    	$users=$t->getuserinfo($uid);
    	$yinhang=Payment::where('user_id',$uid)->where('type',3)->get();

    	return view('home.user.choosebnak',compact('yinhang','users'));
    }
    #提现
    public function withdrawals(){
    	$uid=$this->checkUser();
    	$t = new User;
    	$users=$t->getuserinfo($uid);
    	return view('home.user.withdrawals',compact('users')); 	
    }
    #转账提交
    public function editaccount(Request $request){
    	$uid=$this->checkUser();
    	$t = new User;
    	$users=$t->getuserinfo($uid);

    	$post=$request->input();
    	if($post['id']=='' || $post['num']=='' ){
    		return $this->ajaxMessage(false,'参数错误');
    	}
    	if($post['num'] < 50){
    		return $this->ajaxMessage(false,'数量最低为50');
    	}
        #判断直推会员
        $countzhi=User::where('pid',$uid)->count();
        
        if($countzhi < 3){
            return $this->ajaxMessage(false,'必须有3个直推会员才可以此操作');
        }

    	if($post['id'] ==1 ){
    		#转账逻辑处理
    		$puser=User::where('phone',$post['phone'])->first();
    		if($puser['id']==$uid){
    			return $this->ajaxMessage(false,'不能转账给自己');
    		}
    		if($puser){
    			if($post['num'] > $users['account']){
    				return $this->ajaxMessage(false,'账户余额不足');
    			}
	    	if($post['code'] !=session('yzmCode')){
	           				return $this->ajaxMessage(false,'短信验证码错误');
	           		}

#事物开始
            #加载配置
            $res=DB::table('config')->where('id',1)->first();
            $shouxu=  100 * 0.01 - $res->zhuanzhang  * 0.01;
            $puser=User::where('phone',$post['phone'])->first();

       
			$num=0;

//开启事务 
DB::beginTransaction();
try{ 
	User::where('id',$uid)->decrement('account', $post['num']);
    User::where('phone',$post['phone'])->increment('account', $post['num'] * $shouxu);
    			$data=[];
    			$data['user_id']=$puser['id'];
    			$data['type']=2;
    			$data['flag']=1;
    			$data['recode_info']='转账';
    			$data['status']=2;
    			$data['from_id']=$uid;
    			
    			$data['money']=$post['num'] * $shouxu;
    			$data['create_at']=time();
    			$data['update_at']=time();
    			$ress=Incomerecode::insert($data);


                $data=[];
                $data['user_id']=$uid;
                $data['type']=2;
                $data['flag']=2;
                $data['recode_info']='转账';
                $data['status']=2;
                $data['from_id']=$puser['id'];
                $data['money']=$post['num'];
                $data['create_at']=time();
                $data['update_at']=time();
                $res=Incomerecode::insert($data);

                $dada=[];
                $dada['cid']=$uid;
                $dada['jid']=$puser['id'];
                $dada['money']=$post['num'];
                $dada['truemoney']=$post['num'] * $shouxu;
                $dada['create_at']=time();
                $ress=DB::table('trueaccounts')->insert($dada);
                $num=1;
	

//中间逻辑代码 
	DB::commit(); 
}catch (\Exception $e) { 
//接收异常处理并回滚 
	DB::rollBack(); 
}
 			

                if($num==1){

	   				    return $this->ajaxMessage(true,'操作成功',['flag'=>1]);
                    }else{
                        return $this->ajaxMessage(false,'参数错误');
                    }

				// }else{
				// 	return $this->ajaxMessage(false,'参数错误');
				// }
#事物结束



    		}else{
    			return $this->ajaxMessage(false,'该用户不存在');
    		}

    	}elseif ($post['id']==2) {
    		#提现逻辑处理
                    #加载配置


            $res=DB::table('config')->where('id',1)->first();
            $xitian=  100 * 0.01 - $res->tixian  * 0.01;

            $countzhi=User::where(['pid'=>$uid,'level'=>1])->count();
            if($countzhi < 3 ){
                return $this->ajaxMessage(false,'用户下必须有三个直推会员才可以提现');
            }
            $time=strtotime(date("Y-m-d"),time());
            $endtime=$time + 86400;
            $ticount=Withdraw::where('user_id',$uid)->whereBetween('create_at',[$time,$endtime])->count();
            if($ticount >= $res->tixanshu){
            	return $this->ajaxMessage(false,'超过每天提现次数');
            }
            
    		if($post['num'] > $users['account']){
    				return $this->ajaxMessage(false,'账户余额不足');
    			}

            #判断有无支付宝微信 1支付宝 2微信 3银行卡
                if($post['type']==2){
                     //$parent=Payment::where('user_id',$uid)->where('type',2)->first();
                     if($users['openid']==''){
                        return $this->ajaxMessage(false,'未绑定微信，请前往账户绑定');
                     }
                     if($post['num'] > 200){
                        return $this->ajaxMessage(false,'微信每次最多200元');
                     }


                }elseif($post['type']==1){
                   
                     $parent=Payment::where('user_id',$uid)->where('type',2)->first();
                    
                     if(empty($parent)){

                        return $this->ajaxMessage(false,'未绑定支付宝，请前往账户绑定');
                     }
                     if($post['num'] > 2000){
                        return $this->ajaxMessage(false,'支付宝每次最多2000元');
                     }

                }elseif($post['type']==3){
               
                        return $this->ajaxMessage(false,'银行卡提现暂未开放');
                   
                }
           		if($post['code'] !=session('yzmCode')){
           				return $this->ajaxMessage(false,'短信验证码错误');
           		}

 $num=0;
 #开启事务 
DB::beginTransaction();
try{ 			 
    			User::where('id',$uid)->decrement('account', $post['num']);

                $tixiannum=$xitian-0.3;
    			#添加到提现表 百分70
    			$data=[];
    			$data['user_id']=$users['id'];
    			$data['mobile']=$users['phone'];
    			$data['name']=$users['name'];
    			$data['money']=$post['num'];
    			$data['arrival_money']=$post['num'] * $tixiannum;
                $data['out_biz_no']=$this->order_num();
    			$data['cash_way']=$post['type'];

    			$data['create_at']=time();
    			$data['update_at']=time();

    			// if($post['number']!=''){
    			// 	$data['money']=$post['number'];
    			// }
    			Withdraw::insert($data);
                #添加到Pointsrecode
                $dddd=[];
                $dddd['user_id']=$users['id'];
                $dddd['flag']=2;
                //$dddd['points_info']='提现';
                $dddd['money']=$post['num'];
                $dddd['status']=1;
                $dddd['type']=6;
                $dddd['create_at']=time();
                incomerecode::insert($dddd);


    			#添加复投积分 20%
    			$dataf=[];
    			$dataf['user_id']=$users['id'];
    			$dataf['flag']=1;
    			$dataf['points_info']='提现获得';
    			$dataf['sign']=1;
    			$dataf['points']=$post['num'] * 0.20;
                $dataf['create_at']=time();
    			Pointsrecode::insert($dataf);
    			User::where('id',$users['id'])->increment('repeat_points', $post['num'] * 0.20);

    			#添加到消费积分 10%
    			$datax=[];
    			$datax['user_id']=$users['id'];
    			$datax['flag']=2;
    			$datax['points_info']='提现获得';
    			$datax['sign']=1;
    			$datax['points']=$post['num'] * 0.10;
                $datax['create_at']=time();
    			Pointsrecode::insert($datax);
    			$res=User::where('id',$users['id'])->increment('consume_points', $post['num'] * 0.10);
               	$num=1;
	

//中间逻辑代码 
	DB::commit(); 
}catch (\Exception $e) { 
//接收异常处理并回滚 
	DB::rollBack(); 
}
                if($num==1){
                   return $this->ajaxMessage(true,'操作成功',['flag'=>1]); 
               }else{
                    return $this->ajaxMessage(false,'参数错误');
               }
	
#事物结束

    	}
    }

    public function order_num()//生成交易订单号
    {
        $code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderCode = $code[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderCode;
    }




/***
*积分信息
*
**/
    #我的积分
    public function myintegral(){

    	return view('home.user.myintegral');
    }
    #复投积分
    public function recastIntegral(){
    	$uid=$this->checkUser();
    	$t = new User;
    	$users=$t->getuserinfo($uid);
    	$points=$users['repeat_points'];
    	$sintegral=Pointsrecode::where('user_id',$uid)->where('flag',1)->where('sign',1)->orderBy('id','DESC')->get();
    	$zintegral=Pointsrecode::where('user_id',$uid)->where('flag',1)->where('sign',2)->orderBy('id','DESC')->get();
        //dump($points);die;
    	//$points=Pointsrecode::where('user_id',$uid)->sum('points');
    	return view('home.user.recastIntegral',compact('sintegral','zintegral','points'));
    }
    #消费积分
    public function consumption(){
     	$uid=$this->checkUser();
     	$t = new User;
    	$users=$t->getuserinfo($uid);
    	$points=$users['consume_points'];
    	$sintegral=Pointsrecode::where('user_id',$uid)->where('flag',2)->where('sign',1)->orderBy('id','DESC')->get();
    	$zintegral=Pointsrecode::where('user_id',$uid)->where('flag',2)->where('sign',2)->orderBy('id','DESC')->get();

    	//$points=Pointsrecode::where('user_id',$uid)->sum('points');   	
    	return view('home.user.consumption',compact('sintegral','zintegral','points'));
    }
	#循环积分
    public function looppoints(){
    	$uid=$this->checkUser();
    	$t = new User;
    	$users=$t->getuserinfo($uid);
    	$points=$users['loop_points'];
    	$sintegral=Pointsrecode::where('user_id',$uid)->where('flag',3)->where('sign',1)->orderBy('id','DESC')->get();
    	$zintegral=Pointsrecode::where('user_id',$uid)->where('flag',3)->where('sign',2)->orderBy('id','DESC')->get();

    	//$points=Pointsrecode::where('user_id',$uid)->sum('points');
    	return view('home.user.looppoints',compact('sintegral','zintegral','points'));
    }

    #积分转账
    public function turnmyintegral(Request $request,$id){
    	$id=$id;
    	$uid=$this->checkUser();
    	$t = new User;
    	$users=$t->getuserinfo($uid);

    	if($id==1){
    		$points=$users['repeat_points'];
    	}elseif($id ==2){
    		$points=$users['consume_points'];
    	}
    	
    	return view('home.user.turnmyintegral',compact('points','id'));
    }
    #积分转账提交
    public function editintegral(Request $request){
		 	
    	$uid=$this->checkUser();
    	$t = new User;
    	$users=$t->getuserinfo($uid);

    	$post=$request->input();
		
    	if($post['id'] ==''){
    		 return $this->ajaxMessage(false,'参数错误');
    	}
		
		
    	if($pusers=User::where('phone',$post['phone'])->first()){

		}else{
			return $this->ajaxMessage(false,'该用户不存在');
    	
    	}

    	#id 1 复投 2消费积分
    	if($post['num'] < 50){
    		return $this->ajaxMessage(false,'一次转出积分最少为50积分');
    		
    	}
    	if($post['id']==1){
    		$integralnum=$users['repeat_points'];
    	}elseif($post['id'] ==2){
    		$integralnum=$users['consume_points'];
    	}
    	if($post['num'] * 1.05 > $integralnum){
    		return $this->ajaxMessage(false,'该用户积分不足');
    	}
    	#减少积分，给对方增加积分
    	if($post['id'] == 1){
#事物开始
 $num=0;
 #开启事务 
DB::beginTransaction();
try{ 
			$res=User::where('id',$uid)->decrement('repeat_points', $post['num'] * 1.05 ) ; 
			$daaa=[];
    			$daaa['user_id']=$uid;
    			$daaa['flag']=$post['id'];
    			$daaa['points_info']='转账';
    			$daaa['sign']=2;
    			$daaa['points']=$post['num'] * 1.05;
    			Pointsrecode::insert($daaa);

    			$ress=User::where('phone',$post['phone'])->increment('repeat_points', $post['num'] );
    			$data=[];
    			$data['user_id']=$pusers['id'];
    			$data['flag']=$post['id'];
    			$data['points_info']='转账';
    			$data['sign']=1;
    			$data['points']=$post['num'];
    			Pointsrecode::insert($data);
	//中间逻辑代码 
    $num=1;
	DB::commit(); 
}catch (\Exception $e) { 
//接收异常处理并回滚 
	DB::rollBack(); 
}
    			
                if($num==1){
                    return $this->ajaxMessage(true,'操作成功',['flag'=>1]);
                }
	   			
				

    	}elseif($post['id']==2){

#事物开始
 $num=0;
 #开启事务 
DB::beginTransaction();
try{ 
    			User::where('id',$uid)->decrement('consume_points', $post['num']  * 1.05);
    			User::where('phone',$post['phone'])->increment('consume_points', $post['num']);

    			$daaa=[];
    			$daaa['user_id']=$uid;
    			$daaa['flag']=$post['id'];
    			$daaa['points_info']='转账';
    			$daaa['sign']=2;
    			$daaa['points']=$post['num'] * 1.05;
    			Pointsrecode::insert($daaa);

    			$data=[];
    			$data['user_id']=$pusers['id'];
    			$data['flag']=$post['id'];
    			$data['points_info']='转账';
    			$data['sign']=1;
    			$data['points']=$post['num'];
    			$res=Pointsrecode::insert($data);
	//中间逻辑代码 
    $num=1;
	DB::commit(); 
}catch (\Exception $e) { 
//接收异常处理并回滚 
	DB::rollBack(); 
}
  
                if($num==1){
                    return $this->ajaxMessage(true,'操作成功',['flag'=>1]);
                }else{
                    return $this->ajaxMessage(false,'参数错误');
                }

    	}
    	
    }

 /**
 *奖金信息
 *
 **/
 	#我的奖金
 	public function mybonus(){
                $uid=$this->checkUser();
        $t = new User;
        $users=$t->getuserinfo($uid);

 		return view('home.user.mybonus',compact('users'));
 	}
	#见点奖金
 	public function bonus_jiandian(Request $request,$id){
 		$uid=$this->checkUser();
 		$t = new User;
    	$users=$t->getuserinfo($uid);
 		# 1 见点 2分销 3推荐 4升级
 		
 		
 
 		if($id==1){
 			$type=3;
 		}elseif($id==2){
 			$type=1;
 		}elseif($id==3){
 			$type=4;
 		}elseif($id==4){
 			$type=5;
 		}elseif($id==''){
 			$type=3;
 		}
 		#接收分页参数
 		// $post=$request->input();
 		// dd($post);

        $usss=User::select(['pic','id','name'])->get();
         //dump($usss);die;
        $bonus=Incomerecode::where('type',$type)->where('user_id',$uid)->skip(0)->take(20)->orderBy('id','DESC')->get();

            foreach ($bonus as $key => $value) {
                foreach ($usss as $k => $v) {
                        if($value['from_id']==$v['id']){
                            $bonus[$key]['pic']=$v['pic'];
                            $bonus[$key]['name']=$v['name'];
                        }
                }
               
            } 
      
             //return $this->ajaxMessage(false,'您的复投币不足');
		$zbonus=Incomerecode::where('type',$type)->where('user_id',$uid)->sum('money'); 		
		return view('home.user.bonus_jiandian',compact('bonus','id','zbonus','type'));
 	}

/**
*积分升级
*/  
    public function jifenshengji(){
        #查询用户信息 
        $uid=$this->checkUser();
        $roworders=Promoteinfo::where('user_id',$uid)->get();
        //dd($roworders);
        return view('home.user.jifenshengji',compact('roworders'));
    }
 	
/**
*排位订单
*/	
	public function ranking_orders(){
		#查询用户信息 
    	$uid=$this->checkUser();
		$roworders=Roworder::where('user_id',$uid)->orderBy('id','DESC')->get();
		return view('home.user.ranking_orders',compact('roworders'));
	}

    /**
*激活会员订单
*/

    #激活订单
    public function activememberorders(){
        #查询用户信息 
        $uid=$this->checkUser();
        $t = new User;
        $users=$t->getuserinfo($uid);

        return view('home.user.activememberorders',compact('users'));
    }
    #激活会员订单
    public function editactivememberorders(Request $request){
        #查询用户信息 
        $uid=$this->checkUser();
        $t = new User;
        $users=$t->getuserinfo($uid);
        $post=$request->input();

     
        if(! User::where('phone',$post['phone'])->first()){
            return $this->ajaxMessage(false,'用户不存在');
        }else{
            #查询激活用户
            $puser=User::where('phone',$post['phone'])->first();
        }


        if($post['type']==''){
            return $this->ajaxMessage(false,'参数错误');
        }
        if($post['type']==1){
            $money=100;
            $type=4;
            $name='100元区';
        }elseif ($post['type']==2) {
             $money=300;
              $type=5;
               $name='300元区';
        }elseif ($post['type']==3) {
              $money=2000;
               $type=6;
                $name='2000元区';
        }
        if($money > $users['repeat_points']){
            return $this->ajaxMessage(false,'您的复投币不足');
        }
  #事物开始
       $goodsids=DB::table('goods')->where('type',$type)->limit(1)->pluck('id'); 
        if($goodsids){
            $goodsids=$goodsids->toArray();
        }
        $goodsids=implode($goodsids);
        #查询用户收货地址
        $address=Address::where(['user_id'=>$puser['id'],'default'=>1])->first();
        if (!$address) {
            return $this->ajaxMessage(false, '该用户没有默认收获地址');
        }
$num=0;
DB::beginTransaction();
try{    
        $res= User::where('id',$uid)->decrement('repeat_points', $money);
        
 
        #添加复投积分记录
        $dataf=[];
        $dataf['user_id']=$uid;
        $dataf['flag']=2;
        $dataf['points_info']='激活会员订单';
        $dataf['sign']=1;
        $dataf['points']=$money;
        $dataf['create_at']=time();
        Pointsrecode::insert($dataf);
       

        #插入订单
        $add_order=[];
        $add_order['user_id'] = $puser['id'];
        $add_order['order_code'] =  date('Y').date('m').time().rand(1,100);
        $add_order['total_money'] = $money;
        $add_order['status'] = 2;
        $add_order['type'] = 4;
        $add_order['order_num'] = 1;
        $add_order['name'] =  $puser['name'];
        $add_order['phone'] =  $puser['phone'];
        $add_order['province']=$address['province'];
        $add_order['city']=$address['city'];
        $add_order['area']=$address['area'];
        $add_order['address']=$address['address'];
        $add_order['create_at'] = time();
        $add_order['update_at'] = time();
        $add_order['class'] = 2;

        $order_id=Order::insertGetId($add_order);

        $orderinfo=[];
        $orderinfo['order_id']=$order_id;
         
        $orderinfo['name']= $name;
        $orderinfo['price']= $money ;
        $orderinfo['type']=  $type ;
        $orderinfo['goods_id']=  $goodsids ;

        $orderinfo['num']=  1 ;
        $orderinfo['create_at'] = time();
        $orderinfo['update_at'] = time();
        $orders=Orderinfo::insert($orderinfo);
        User::where('id',$puser['id'])->update(['level'=>1]);

        #TODO 接入算法
         $num=1;
        $ress=$this->rowCommonService->index($order_id);
  //中间逻辑代码 
    DB::commit(); 
}catch (\Exception $e) { 
//接收异常处理并回滚 
    DB::rollBack(); 
}      
        if($num==1){
             return $this->ajaxMessage(true,'提交成功',['flag'=>1]);   
        }else{
        	 return $this->ajaxMessage(false,'提交失败，重试');   
        }
          
      
         
    }




/**
*团队
*/
	#我的团队
	public function myteam(){
		#查询用户信息 
    	$uid=$this->checkUser();
    	#查询团队
        $teamm=self::allcount([$uid],0,[]);  #
        $ids = User::whereIn('pid',[$uid])->pluck('id');
        $users = User::select(['id','pid','phone','name','create_at','pic','level'])->whereIn('id',$teamm)->orderBy('id','DESC')->get();
            if($users){
                $users=$users->toArray();
            }
        
        $team=$users;
    	$count=count($team);
         if($team == false){
            $count=0;
        }
       
		return view('home.user.myteam',compact('team','count'));
	}


/****
**账户绑定
*/
	public function accountbinding(){
		$uid=$this->checkUser();
 		$t = new User;
    	$users=$t->getuserinfo($uid);
    	#查询支付宝
    	$zhifu=Payment::where('user_id',$uid)->where('type',2)->first();
    
    		$zhifu= substr_replace($zhifu['number'],'****',3,4);
    	
    	#查询微信
    	$weixin=Payment::where('user_id',$uid)->where('type',1)->first();
    	#查询银行卡
    	$yinhang=Payment::where('user_id',$uid)->where('type',3)->orderBy('id' ,'DESC')->get();


		return view('home.user.accountbinding',compact('zhifu','yinhang','weixin'));
	}
	#添加银行卡
	public function addbank(Request $request){
     
      
		return view('home.user.addbank');
	}
	#绑定支付宝
	public function bindingaliplay(){
        $uid=$this->checkUser();
        $t = new User;
        $users=$t->getuserinfo($uid);
        $phone=substr_replace($users['phone'],'****',3,4);
        $pphone=$users['phone'];

		return view('home.user.bindingaliplay',compact('phone','pphone'));
	}

	public function editbinding(Request $request){
		$uid=$this->checkUser();
 		$t = new User;
    	$users=$t->getuserinfo($uid);
		$post=$request->input();

		if($post['type']==1){



		}elseif ($post['type']==2){

			if($post['code']==session('yzmCode')){
				if($users['pwd']==md5($post['password'])){
						$data=[];
						$data['type']=2;
						$data['user_id']=$users['id'];
						$data['bankname']=$post['bankname'];
						$data['number']=$post['number'];
						$data['phone']=$post['phone'];
						$data['create_at']=time();
						$data['update_at']=$data['create_at'];
						$res=Payment::insert($data);
						if($res){
							return $this->ajaxMessage(true,'绑定成功',['flag'=>1]);
						}

				}else{
					return $this->ajaxMessage(false,'登录密码错误');
				}	
			}else{
				return $this->ajaxMessage(false,'验证码错误');
			}
			#添加银行卡
		}elseif($post['type']==3){
			$count=Payment::where('user_id',$uid)->where('type',3)->count();
			if($count >= 3){
				return $this->ajaxMessage(false,'每人最多可以绑定三张银行卡');
			}
            //dd($post['id']);
			$data=[];
			$data['user_id']=$users['id'];
			$data['type']=3;
			$data['bankname']=$post['bankname'];
			$data['bankusername']=$post['bankusername'];
			$data['number']=$post['number'];
			$data['bankaddress']=$post['bankaddress'];
			$data['create_at']=time();
			$data['update_at']=$data['create_at'];
			$re=Payment::insert($data);
			if($re){
                if($post['id']==5){
                    return $this->ajaxMessage(true,'绑定成功',['flag'=>5]);
                }

				return $this->ajaxMessage(true,'绑定成功',['flag'=>1]);
			}

		}
		

	}
		#删除解绑
	public function bindingdel(Request $request){
        $uid=$this->checkUser();
		$post=$request->input();


        if($post['jie']=='jie'){
             $res=Payment::where('type',2)->where('user_id',$uid)->delete();
        }else{
            $res=Payment::where('id',$post['yinhang'])->where('user_id',$uid)->delete();
        }

		
		if($res){
			return $this->ajaxMessage(true,'操作成功',['flag'=>1]);
		}

	}
/****
*管理收货地址
*
**/	#地址列表
	public function shippingaddress(Request $request){
		$uid=$this->checkUser();
        $dizhi=$request->input('gh');
        if(empty($dizhi)){
            $dizhi=2;
        }

		$address=Address::where('user_id',$uid)->get();
      
		return view('home.user.shippingaddress',compact('address','dizhi'));

	}
	#管理收货地址
	public function manageaddress(Request $request){
		$uid=$this->checkUser();
        $dizhi=$request->input();
         if(empty($dizhi)){
            $dizhi=2;
        }

		$address=Address::where('user_id',$uid)->get();

		return view('home.user.manageaddress',compact('address','dizhi'));
	}
	#设为默认地址
	public function addressdefault(Request $request){
		$uid=$this->checkUser();
		$post=$request->input();
		if($post['type']==1){
			Address::where('user_id',$uid)->update(['default'=>0]);
			Address::where('id',$post['id'])->update(['default'=>1]);
		}elseif(($post['type']==2)){
			Address::where('id',$post['id'])->delete();
		}
	}
    #更换收货地址
    public function addressEdit(){
        $id = $_REQUEST['id'];
        session(['default_address'=>$id]);
        echo 1;
    }
	#添加收货地址页面
	public function toaddress(Request $request){
        $dizhi=$request->input();
         if(empty($dizhi)){
            $dizhi=2;
        }

		return view('home.user.toaddress',compact('dizhi'));
	}
	#添加收货地址
	public function editaddress(Request $request){
		$uid=$this->checkUser();
		$post=$request->input();

		$count=Address::where('user_id',$uid)->count();

		if($count >= 5){
			return $this->ajaxMessage(true,'最多绑定5个收货地址',['flag'=>2]);
		}

		#定义数组
		$data=[];
		//if($post['di']==1){
			Address::where('user_id',$uid)->update(['default'=>0]);

			$data['default']=1;
		//}
	
		$data['user_id']=$uid;
		$data['name']=$post['name'];
		$data['phone']=$post['phone'];

		$address = $post['demo2'];
        $arr = explode(",",$address); 
        $data['province'] = $arr[0];
        $data['city'] = $arr[1];
        if(!empty($arr[2])){
        	$data['area'] = $arr[2];
        }
       
        $data['address']=$post['demo'];
        $data['create_at']=time();
        $data['update_at']=$data['create_at'];
        $res=Address::insert($data);
        if($res){
                if($post['gh']==2){
                   
                    return $this->ajaxMessage(true,'绑定成功,请重新选择收货地址',['flag'=>2]);
                }

              
        	return $this->ajaxMessage(true,'绑定成功',['flag'=>1]);
        }

	}


    /*****
    *****用户订单
    ****
    */
    public function userorder(Request $request,$type){
        $uid=$this->checkUser();
        #待付款
        $order_a=self::userorderinfo(1, $uid);
        #待发货
        $order_b=self::userorderinfo(2, $uid);
        #待收货
        $order_c=self::userorderinfo(3, $uid);
        #已收货
        $order_d=self::userorderinfo(4, $uid);
        return view('home.user.userorder',compact('order_d','order_a','order_b','order_c'));
    }

    static function userorderinfo($i,$uid){
       
       
        $list=Order::where('user_id',$uid)->where('status',$i)->orderBy('id','desc')->get();

        foreach ($list as $k => $v) {
            $info=Orderinfo::select(['order_id','price','num','name','goods_id'])->where('order_id',$v['id'])->get();
                foreach ($info as $key => $value) {
                    $goods=Goods::select(['id','pic','name'])->where('id',$value['goods_id'])->first();
                    $info[$key]['name']=$goods['name'];
                    $info[$key]['pic']=$goods['pic'];

                }

                $list[$k]->info = $info;

        
        }
        return $list;
    }
    #订单详情
    public function userorderin(Request $request,$id){
        $uid=$this->checkUser();
            $list=Order::where('id',$id)->first();

      
            $info=Orderinfo::select(['order_id','price','num','name','goods_id'])->where('order_id',$list['id'])->get();
                foreach ($info as $key => $value) {
                    $goods=Goods::select(['id','pic','name'])->where('id',$value['goods_id'])->first();
                    $info[$key]['name']=$goods['name'];
                    $info[$key]['pic']=$goods['pic'];
                }
                $list->info = $info;
      
        
        return view('home.user.userorderin',compact('list'));
   }
    #订单操作
    public function edituserorder(Request $request){
        $uid=$this->checkUser();
        $post=$request->input();

        #1 取消订单，2提醒发货，3确认收货
        if($post['type']==1){
        #查询订单,增加库存
        $info=Orderinfo::select(['order_id','price','num','name','goods_id'])->where('order_id',$post['id'])->get();
                foreach ($info as $key => $value) {
                    $goods=Goods::where('id',$value['goods_id'])->increment(['storage'=>$value['num']]);
                }


            $res=Order::where('id',$post['id'])->delete();
            $ress=Orderinfo::where('order_id',$post['id'])->delete();
            if($res && $ress){
                return $this->ajaxMessage(true,'删除成功',['flag'=>1]);
            }else{
                return $this->ajaxMessage(false,'删除失败');
            }

        }elseif ($post['type']==2) {

            $res=Order::where('id',$post['id'])->first();
            if($res['update_at'] + 86400 > time() ){
                 return $this->ajaxMessage(false,'自下单开始，一天之内提醒一次。最多三次');
            }
            if($res['tixin'] > 3){
                 return $this->ajaxMessage(false,'已到达提醒次数');
            }
            $data=[];
            $data['tixin']=$res['tixin'] +1;
            $data['update_at']=time();
            $ress=Order::where('id',$post['id'])->update($data);
            if($ress){
                 return $this->ajaxMessage(true,'提醒成功',['flag'=>1]);
            }
        
        }elseif ($post['type']==3) {
            $data=[];
            $data['status']=4;
            $data['update_at']=time();
            $ress=Order::where('id',$post['id'])->update($data);
            if($ress){
                 return $this->ajaxMessage(true,'操作成功',['flag'=>1]);
            }
        }



    }


    #注销
    public function logout(Request $request){
        $user_id=$this->checkUser();

        //$res = $request->session()->all();
        //dd($res);
        $user=User::find($user_id);
        $user->status=2;
        if($user->save()){
//            $request->session()->forget('info');
            $request->session()->forget('phone');
            $request->session()->forget('home_user_id');
            return redirect('/');
        }
    }


    #众筹奖金
    public function crowdfunding()
    {   
        $user_id=$this->checkUser();

        $love = DB::table('order2')->where(['user_id'=>$user_id])->where('status','>=',2)->sum('total_money');
        $count = DB::table('balance_records2')->where(['user_id'=>$user_id,'type'=>1])->sum('num');
        return view('home.user.crowdfunding',compact('love','count'));
    }   

    #众筹奖金
    public function loverDetail()
    {
        return view('home.user.loverDetail',compact(''));
    }    

    #股东分红
    public function stockBonus()
    {
        return view('home.user.stockBonus',compact(''));
        
    }
    #爱心奖金
    public function loverBonus()
    {
        return view('home.user.loverBonus',compact(''));
    }

    #爱心分销奖
    public function loverDistribution()
    {
        return view('home.user.loverDistribution',compact(''));
    }

    #爱心领导奖
    public function loverleader()
    {   
        $user_id=$this->checkUser();
        $countMoney = DB::table('balance_records2')->where(['user_id'=>$user_id,'type'=>2])->sum('num');
        #未判断是否封顶
        return view('home.user.loverleader',compact('countMoney'));
    }

    #爱心领导奖几代
    public function loverleader2()
    {
        $type = $_GET['type'];
        $data = [];
        return view('home.user.loverleader2',compact('type','data'));
    }

    #我的团队
    public function myTeam_new()
    {   
        $user_id=$this->checkUser();
        $count = count($this->child([$user_id],[]));   
        if ($count) {
            $one = count($this->getChilden([$user_id],1));
            $two = count($this->getChilden([$user_id],2));
            $three = count($this->getChilden([$user_id],3));
            $other = $count - $one - $two - $three;
        }else{
            $one = 0;
            $two = 0;
            $three = 0;
            $other = 0;
        }
        return view('home.user.myTeam_new',compact('one','two','three','other','count'));

    }

    #团队列表
    public function teamList()
    {
        $user_id=$this->checkUser();

        $type = $_GET['type'];  //团队几级
        if ((int)$type > 3) {
            $id = $this->getChilden([$user_id],1);  
        }else{
            $id = $this->getChilden([$user_id],$type);  
        }

        if (!empty($id)) {
            $data = DB::table('user')->whereIn('id',$id)->get();
        }else{
            $data = [];
        }
        return view('home.user.teamList',compact('type','data'));
    }

    /**
     * 获取指定级别下级
     * @param $uid char 要查询下级的用户集合id；如[1,2,3]
     * @param $num int   要查询的级别
     * @return 查询级别的用户下级
     */
    public function getChilden($uid,$num = 1){
        $user1 = DB::table('user')->whereIn('pid',$uid)->select('id','pid')->get();
        $user1 = json_decode(json_encode($user1),true);

        $users_id = [];
        foreach($user1 as $k=>$v){
            $users_id[] = $v['id'];
        }

        for($i = 1;$i < $num;$i++){
            if(!$users_id){
                return $users_id;
            }
            $users_id = $this->getChilden($users_id,$num-1);
            return $users_id;
        }
        return $users_id;
    }

    #查询无限下级用户id
    #$id []
    public function child($id,$data = [])
    {   
        $user1 = DB::table('user')->whereIn('pid',$id)->pluck('id');
        $user1 = json_decode(json_encode($user1),true);
        if ($user1) {
            $allUser = [];
            foreach ($user1 as $k => $v) {
                $data[] = $v;
                $allUser[] = $v;
            }
            $data = $this->child($allUser,$data);
        }else{
            $data = array_merge($user1,$data);
        }
            return $data;
    }

}
