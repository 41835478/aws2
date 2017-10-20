<?php

namespace App\Listeners;



use App\Http\Services\CreateOrderService;
use App\Http\Services\RowService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


use App\Http\Model\User;
use DB;
use Exception;
use Illuminate\Support\Facades\Redis;
use App\Events\AcoutEvent;

class AcoutEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $createOrder;
    protected $row;

    public function __construct(CreateOrderService $createOrder,RowService $row)
    {
        $this->createOrder = $createOrder;
        $this->row=$row;
    }

    /**
     * Handle the event.
     *
     * @param  RowAEvent $event
     * @return void
     */
    public function handle(AcoutEvent $event)
    {
        $id=$event->user_id;
        $this->wuxian($id);
    }

    #查询团队
    public static function wuxian($i){
        $users = [];
        $num=0;

        ($user = User::select(['id','pid','phone','name','create_at','pic','level'])-> where(['pid'=>$i]) -> get()) && $user = $user -> toArray();
        if(count($user) > 0){
            $users = array_merge($users,$user);
            foreach ($user as $key => $value) {

                $tmp = self::wuxian($value['id']);

                $num=$num + 1 ;

                if(count($tmp) > 0 && $tmp != false){
                    $users = array_merge($users,$tmp);
                }else{
                    continue;
                }

            }

            if($num == 10){
                $count=count($users);
                User::where('id',$i)->update(['mynumcount'=>$count]);
                return $users;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }





















}
