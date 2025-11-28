<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Staff extends Model
{
    protected $fillable =['name','sex','phone','profile','dob','dop','position','salary','status','user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
