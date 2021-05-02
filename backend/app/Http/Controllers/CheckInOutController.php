<?php

namespace App\Http\Controllers;

use App\Models\CheckInOut;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckInOutController extends Controller
{
    public function checkIn(Request $request){
        $dateTime = Carbon::now();
        $data = $request->all();
        $data['date'] = $dateTime->toDateString();
        $data['check_in'] = $dateTime->toTimeString();

        $save = CheckInOut::checkIn($data);
        return response()->json(['status' => 'Success'],200);
    }


    public function getInfo($id){
        $getInfo = User::select('company_id','branch_id')->where('id', $id)->first();
        return response()->json(['getInfo' => $getInfo],200);
    }
}
