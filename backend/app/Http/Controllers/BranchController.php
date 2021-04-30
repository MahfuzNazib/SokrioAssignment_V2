<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function createBranch(Request $request){
        $data = $request->all();
        $saveBranch = Branch::createBranch($data);
        return response()->json(['status' => 'Success'],200);
    }

    public function branchIndex(){
        $branch_list = Branch::where('status' , 1)->get();
        return response()->json(['status' => 'Success','branch_list' => $branch_list], 200);
    }

    // Edit Branch 
    public function branchEdit($id){
        $branch_info = Branch::find($id);
        return response()->json(['status' => 'Success','branch_info' => $branch_info], 200);
    }

    public function branchUpdate($id, Request $request){
        $data = $request->all();
        Branch::branchUpdate($id, $data);
        return response()->json(['status' => 'Success'],200);
    }

    // Delete Branch
    public function branchDelete($id){
        $branch_delete = Branch::where('id', $id)->update(['status' => 0]);
        return response()->json(['status' => 'Success'], 200);
    }

    // Search Function
    public function branchSearch($search_string){
        $search_result = Branch::where('branch_name', 'like', '%'.$search_string.'%')
                                ->orWhere('address', 'like', '%'.$search_string.'%')
                                ->get();

        return response()->json(['status' => 'Success','search_result' => $search_result], 200);
    }

    
}
