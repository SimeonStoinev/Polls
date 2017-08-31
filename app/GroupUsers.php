<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GroupUsers extends Model
{
    protected $table = 'group_members';
    protected $fillable = [
        'id', 'user_id', 'group_id', 'status', 'rank'
    ];

    public function scopeGetGroupMembers($query, $groupId){
        return $query->where('group_id', $groupId)->where('group_members.status', 'active')->leftJoin('users', 'users.id', '=', 'user_id')->select('group_members.status as status','user_id','group_members.rank as rank','name','email')->where('user_id', '!=', Auth::user()['id']);
    }


    public function scopeGetAllGroupUsers($query, $groupId){
        return $query->where('group_id', $groupId)->where('group_members.status', '!=', 'pending')->leftJoin('users', 'users.id', '=', 'user_id')->select('group_members.status as status','user_id','group_members.rank as rank','name','email');
    }


    public function scopeGetGroupOwner($query, $groupId){
        return $query->where('group_id', $groupId)->where('group_members.rank', 'owner')->leftJoin('users', 'users.id', '=', 'user_id')->select('group_members.status as status','user_id','group_members.rank as rank','name','email');
    }


    public function scopeGetPendingGroupMembers($query, $groupId){
        return $query->where('group_id', $groupId)->where('group_members.status', 'pending')->leftJoin('users', 'users.id', '=', 'user_id')->select('group_members.status as status','user_id','group_members.rank as rank','name','email')->where('user_id', '!=', Auth::user()['id']);
    }
}
