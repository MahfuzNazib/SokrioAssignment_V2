<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = ['company_id', 'branch_name', 'address', 'phone', 'status'];

    public static function createBranch($requestData){
        try{
            $id = static::create($requestData);
            return $id;
        }catch(\Exception $e){
            throw new \Exception($e->getMessage(), 1);               
        }
    }

    // Update Branch
    public static function branchUpdate($id, $requestData){
        try{
            $id = static::find($id);
            $id->fill($requestData)->update();
            return $id;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage(), 1);  
        }
    }
}
