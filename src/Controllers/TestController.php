<?php

namespace Large\Zhengdada\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TestController extends Controller
{
    /**
     * 个人主页
     */
    public function index(Request $request)
    {
        return view("large::test.index");
    }
}