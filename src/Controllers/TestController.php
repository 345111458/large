<?php

namespace Large\Zhengdada\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Large\Zhengdada\Functions;


class TestController extends Controller
{
    /**
     * 个人主页
     */
    public function index(Request $request)
    {
        return view("large::test.index");
    }


    public function dirTree(Request $request)
    {
        $path = base_path().'/'.$request->path;

        if (!file_exists($path)) {
            return response()->json(['msg' => '参数有误', 'status' => 'error']);
        }

        $res = collect(Functions::dirTree($path));

        $str = [];
        foreach ($res as $k => &$v) {
            $str[$k]['value'] = $path . $v;
            $str[$k]['label'] = $path . $v;
        }
        return response()->json(['msg' => $str, 'status' => 'success']);;
    }

}
