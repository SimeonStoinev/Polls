<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class Pool extends Model
{
    protected $table = 'pools';
    protected $fillable = [
        'id', 'question', 'answers', 'creator_id', 'status', 'for_users', 'slug'
    ];

    public function scopeGetPoll($query, $id){
        return $query->where('id', $id);
    }

    public function scopeGetPublicPoll($query, $slug){
        return $query->where('slug', $slug)->where('for_users', 'public');
    }

    public function scopeGetPollbyIdAndUserId($query, $id, $user_id){
        return $query->where('id', $id)->where('creator_id', $user_id);
    }

    public function scopeGetMinePolls($query){
        return $query->where('creator_id', Auth::user()['id']);
    }

    public function scopeGetMineForAllPolls($query){
        return $query->where('creator_id', Auth::user()['id'])->where('for_users', 'all')->where('status', 'active');
    }

    public function scopeGetAllForAllPolls($query){
        return $query->where('for_users', 'all')->where('pools.status', 'active')->leftJoin('users', 'users.id', '=', 'creator_id')->select('pools.id as id', 'question', 'answers', 'creator_id', 'pools.status as status', 'for_users', 'slug', 'name');
    }

    public function scopeGetAllPolls($query){
        return $query->where('creator_id', '!=', Auth::user()['id'])->where('pools.status', 'active')->where('for_users', 'all')->leftJoin('users', 'users.id', '=', 'creator_id')->select('pools.id as id', 'question', 'answers', 'creator_id', 'for_users', 'slug', 'name');
    }



}
