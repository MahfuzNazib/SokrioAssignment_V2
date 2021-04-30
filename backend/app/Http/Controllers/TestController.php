<?php

namespace App\Http\Controllers;

use App\Models\saveinfo;
use Illuminate\Http\Request;


class TestController extends Controller
{
    public function saveinfo(Request $request){
        $data = $request->all();
        $save = saveinfo::createSaveInfo($data);
        return response()->json(['status' => 'Success']);
    }

    public function getDept()
    {
        $dept = saveinfo::all();
        return response()->json(['status' => 'Success', 'dept' => $dept]);
    }
}
