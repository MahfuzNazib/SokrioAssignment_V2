<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function employeeRegister(Request $request){
        // Server side Data Validation
        $validate = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'branch_id' => 'required',
            'menuroles' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 200);
        }
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        // Checking Previous Manager is exists or not
        if($request->menuroles == 'manager'){
            $checkManager = Branch::where('id', $request->branch_id)->first();
            if($checkManager->set_manager == 1){
                return response()->json(['status' => 'manager_exists'],200);
            }else{
                DB::table('branches')->where('id', $request->branch_id)->update(['set_manager' => 1]);
            }
        }else{
            User::registerNewUser($data);
            return response()->json(['status' => 'Success'],200);
        }
        
    }

    public function employeeIndex($id){
        $company_id = Company::where('user_id', $id)->first();
        $employee_list = User::with('branch')->where('company_id', $company_id->id)->get();
        return response()->json(['status' => 'Success', 'employee_list' => $employee_list],200);
    }

    public function employeeSearch($search_string){
        $search_result = User::with('branch')->where('name', 'like', '%'.$search_string.'%')
        ->orWhere('email', 'like', '%'.$search_string.'%')
        ->get();
        return response()->json(['status' => 'Success','search_result' => $search_result], 200);
    }
}