<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Profiles extends Model
{
    public function getuserDetails($userid){
       
       return User::find($userid);
    }
    public function users(){

        return $this->belongsTo(User::class, 'id');

    } 
  
}
