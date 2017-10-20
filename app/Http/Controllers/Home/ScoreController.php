<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 9:38
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Model\User;
use App\Http\Services\AuthService;
use Cache;
class ScoreController extends Controller
{

    /*
    *积分商城
    */
    const GS = 'goods';
    const GC = 'goodsclass';
    const US = 'user';
    const ADS = 'address';
    const IPS = 'pointsrecode';
    #首页
    public  function  index(){
        #查询用户信息
        $auth = new AuthService();
        $uid = $auth->rememberDecrypt(\Session::get('home_user_id'));
        #我的积分
        if($users=DB::table(self::US)->where(['id'=>$uid])->first()){
            $return['score'] = $users->consume_points;
        }else{
            $return['score'] = 0;
        }
        #积分商城分类
        $return['class'] = DB::table(self::GC)->where(['type'=>3])->get();
        #热门推荐
        $return['hots'] = DB::table(self::GS)->where(['type'=>3,'hots'=>1,'status'=>1])->get();
        return view('home.score.integralMall',$return);
    }
   #商品分类列表
    public  function  lists(Request $request){
        $class = $request->input('c');
        if(empty($class)){
            exit("<script>alert('参数错误');history.go(-1)</script>");
        }
        $return['goods'] = DB::table(self::GS)->where(['type'=>3,'class_id'=>$class,'status'=>1])->get();
        $return['class'] = DB::table(self::GC)->where(['id'=>$class])->first();
//        dd($return);exit;
        return view('home.score.integralMall_list',$return);
    }
   #商品详情
    public  function  info(Request $request){
        #查询用户信息
        $auth = new AuthService();
        $uid = $auth->rememberDecrypt(\Session::get('home_user_id'));
        if(empty($uid)){
            exit("<script>alert('请先登录');location.href='/login/login'</script>");
        }
        $da = DB::table(self::ADS)->where(['user_id'=>$uid,'default'=>1])->first();
        $df = DB::table(self::ADS)->where(['user_id'=>$uid])->first();
        $return['address'] = $da?:($df?:null);
        $class = $request->input('s');
        if(empty($class)){
            exit("<script>alert('参数错误');history.go(-1)</script>");
        }
        $return['goods'] = DB::table(self::GS)->where(['type'=>3,'id'=>$class,'status'=>1])->first();
        if(empty($return['goods'])){
            exit("<script>alert('参数错误');history.go(-1)</script>");
        }
        $return['goods']->small_pic = json_decode($return['goods']->small_pic,true);
//        dd($return);exit;
        return view('home.score.goodsDetail_integral',$return);
    }
    #兑换
    public  function  exchange(Request $request){
        $id = $request->input('id');
        $goods = DB::table(self::GS)->where(['type'=>3,'id'=>$id,'status'=>1])->first();

        #查询用户信息
        $auth = new AuthService();
        $uid = $auth->rememberDecrypt(\Session::get('home_user_id'));
        if(empty($uid)){
            exit("<script>alert('请先登录');location.href='/login/login'</script>");
        }
        $user = DB::table(self::US)->where(['id'=>$uid])->first();
        if(empty($id)||empty($goods)||empty($user)){
            return response()->json(['status'=>0,'msg'=>'参数错误']);
        }
        if($goods->money > $user->consume_points){
            return response()->json(['status'=>0,'msg'=>'您的积分不足，看看别的吧！']);
        }
        #开启事务
        DB::beginTransaction();
        #扣积分
        $res =  DB::table(self::US)->where(['id'=>$uid])->decrement('consume_points', $goods->money);
        $insert['user_id'] = $uid;
        $insert['flag'] = 2;//消费积分
        $insert['sign'] = 2;//支出
        $insert['points_info'] = '积分商城消费';
        $insert['points'] = $goods->money;
        $insert['create_at'] = $insert['update_at'] = time();
        $res1 =  DB::table(self::IPS)->insertGetId($insert);
        if($res && $res1){
            DB::commit();
            return response()->json(['status'=>1,'msg'=>'兑换成功']);
        }else{
            DB::rollBack();
            return response()->json(['status'=>0,'msg'=>'兑换失败']);
        }

    }

}
?>