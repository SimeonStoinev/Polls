<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirmToken', 'unsubToken', 'thumbnail', 'status', 'rank'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function scopeGetUser($query, $userId){
        return $query->where('rank', 'member')->where('status', 'active')->where('id', $userId);
    }


    public function scopeGetTokenByUser($query){
        $user = Auth::user();
        return $query->where('token', $user->token);
    }


    public function scopeGetAllMembers($query){
        return $query->where('rank', 'member')->where('id', '!=', Auth::user()['id'])->select('id', 'name', 'email', 'status', 'rank')->get();
    }


    public function scopeGetAllAdmins($query){
        return $query->where('rank','admin')->select('id', 'name', 'email', 'status', 'rank')->get();
    }


    public function scopeSearchUsers($query, $searchString){
        return $query->where('email', $searchString)->orWhere('name', $searchString);
    }


    public function scopeGetAllActiveMembers($query){
        return $query->where('rank', 'member')->where('status', 'active')->where('id', '!=', Auth::user()['id'])->select('id', 'name', 'email');
    }
}
