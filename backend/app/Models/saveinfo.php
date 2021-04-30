<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saveinfo extends Model
{
    protected $table="saveinfo";
    protected $fillable = ['code','department'];

    public static function createSaveInfo($requestData){
        try{
            $id = static::create($requestData);
            return $id;
        }catch(\Exception $e){
            throw new \Exception($e->getMessage(), 1);               
        }
    }
}
