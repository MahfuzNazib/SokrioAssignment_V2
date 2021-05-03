<?php

namespace App\Http\Controllers;

use App\Models\CheckInOut;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckInMail;

class CheckInOutController extends Controller
{

    private function earlyCheckInTime(){
        $dateTime = Carbon::now();
        $time = $dateTime->toTimeString();
        $ThatTime ="07:45:00";
        if (time() >= strtotime($ThatTime)) {
            return true;
        }else{
            return false;
        }
    }

    public function checkIn(Request $request){
        $dateTime = Carbon::now();
        $data = $request->all();
        $data['date'] = $dateTime->toDateString();
        $data['check_in'] = $dateTime->toTimeString();

        self::earlyCheckInTime();
        if($this->earlyCheckInTime() == true){
            // get Branch Manager Email;
            $managerEmail = User::where('company_id', $data['company_id'])->where('branch_id', $data['branch_id'])->select('email')->first();
            // Get Employee Name
            $data['emp_name'] = User::where('id', $data['user_id'])->select('name')->first();

            $save = CheckInOut::checkIn($data);
            Mail::to($managerEmail)->send(new CheckInMail($data));
            return response()->json(['status' => 'Success'],200);
        }else{
            return response()->json(['status' => 'early_check_in'],200);
        }
        
    }


    public function getInfo($id){
        $getInfo = User::select('company_id','branch_id')->where('id', $id)->first();
        return response()->json(['getInfo' => $getInfo],200);
    }
}
