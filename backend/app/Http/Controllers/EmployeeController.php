<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function employeeRegister(Request $request){
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        return $data;
    }
}
