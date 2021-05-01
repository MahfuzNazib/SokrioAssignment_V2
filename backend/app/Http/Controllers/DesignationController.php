<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function createDesignation(Request $request){
        $data = $request->all();
        $save = Designation::createDesignation($data);

        return response()->json(['status' => 'Success'],200);
    }
}
