<?php

namespace App\Http\Controllers\Admin2;

use App\Http\Model\Investment2;
use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        $userQuery = User::query();
        if ($request->has('name'))
            $userQuery->where('name', 'like', '%' . $request->name . '%');
        if ($request->has('phone'))
            $userQuery->where('phone', 'like', '%' . $request->phone . '%');

        $user_ids = $userQuery->pluck('id');
        $query = Investment2::query();
        if ($request->has('start'))
            $query->where('created_at', '>=', $request->start);
        if ($request->has('end'))
            $query->where('created_at', '<=', $request->end);
        if ($request->has('status'))
            $query->where('status', $request->has('status'));

        if ($request->has('name') || $request->has('phone')) {
            $investments = $query->whereIn('user_id', $user_ids)->paginate(config('admin.pages'));
        } else {
            $investments = $query->paginate(config('admin.pages'));
        }
        $total = $investments->total();
        $page = ceil($total / config('admin.pages'));//共几页

        $currentPage = $investments->currentPage();//当前页
        return view('admin.investment2.index', compact('investments', 'total', 'page', 'currentPage'));
    }
}
