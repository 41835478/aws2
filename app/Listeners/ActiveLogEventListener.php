<?php

namespace App\Listeners;

use App\Http\Model\Admin\Admin;
use App\Http\Model\Admin\Activelog;
use App\Http\Services\AdminService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ActiveLogEvent;

class ActiveLogEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $adminService;
    protected $admin;
    protected $activeLog;
    public function __construct(AdminService $adminService,Admin $admin,Activelog $activeLog)
    {
        $this->adminService=$adminService;
        $this->admin=$admin;
        $this->activeLog=$activeLog;
    }

    /**
     * Handle the event.
     *
     * @param  RowEvent  $event
     * @return void
     */
    public function handle(ActiveLogEvent $event)
    {
        $info=$event->info;
        $arr=$this->adminService->getUserInfo();
        $where=['id'=>$arr[1],'mobile'=>$arr[0]];
        $name=$this->admin->where($where)->value('name');
        $date['name']=$name;
        $date['mobile']=$arr[0];
        $date['log_content']=$info;
        $this->activeLog->create($date);
    }
}
