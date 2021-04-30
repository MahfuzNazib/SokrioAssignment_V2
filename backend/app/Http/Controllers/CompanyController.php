<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function companyInfo($id){
        $company_info = Company::where('user_id', $id)->first();
        return response()->json(['company_info' => $company_info], 200);
    }
}
