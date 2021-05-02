<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
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
        $save = User::registerNewUser($data);
        return response()->json(['status' => 'Success'],200);
    }

    public function employeeIndex($id){
        $company_id = Company::where('user_id', $id)->first();
        $employee_list = User::where('company_id', $company_id->id)->get();

        return response()->json(['status' => 'Success', 'employee_list' => $employee_list],200);
    }
}
