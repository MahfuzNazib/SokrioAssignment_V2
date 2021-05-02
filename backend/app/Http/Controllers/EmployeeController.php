<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function employeeRegister(Request $request){
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $save = User::registerNewUser($data);
        return response()->json(['status' => 'Success'],200);
    }
}
