<?php

namespace App\Http\Controllers\Admin2;

use App\Http\Controllers\Controller;
use App\Http\Model\Admin\Admin;
use App\Http\Services\AdminService;

class IndexController extends Controller
{
    protected  $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        $res = $this->adminService->getUserInfo(session('info'));
        $result=Admin::find($res[1]);
        $time=getTime();
        return view('admin.index.index',compact('time','result'));
    }
}
