<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Votes extends Model
{
    protected $table = 'votes';
    protected $fillable = [
        'id', 'user_id', 'pool_id', 'a0', 'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'ip_address', 'user_agent'
    ];

    public function scopeGetVotedPolls($query){
        return $query->where('user_id', Auth::user()['id'])->leftJoin('pools', 'pools.id', '=', 'pool_id')->leftJoin('users', 'users.id', '=', 'creator_id');
    }

    public function scopeGetVotes($query, $poolId){
        return $query->where('pool_id', $poolId)->select( DB::raw(" sum(a0) as a0, sum(a1) as a1 , sum(a2) as a2, sum(a3) as a3, sum(a4) as a4, sum(a5) as a5, sum(a6) as a6 , sum(a7) as a7 , sum(a8) as a8 , sum(a9) as a9, sum(a0 + a1 + a2 +  a3  + a4 +  a5  + a6 + a7 + a8  +  a9) as allItems " ))->first();
    }

    public function scopeGetVotesPublic($query, $poolId){
        return $query->where('pool_id', $poolId)->select( DB::raw(" sum(a0) as a0, sum(a1) as a1 , sum(a2) as a2, sum(a3) as a3, sum(a4) as a4, sum(a5) as a5, sum(a6) as a6 , sum(a7) as a7 , sum(a8) as a8 , sum(a9) as a9, sum(a0 + a1 + a2 +  a3  + a4 +  a5  + a6 + a7 + a8  +  a9) as allItems" ))->leftJoin('pools', 'pools.id', '=', 'pool_id')->where('for_users', 'public')->first();
    }

    /*public function scopeGetNotVotedPolls($query){
        return $query->where('user_id', '!=', Auth::user()['id'])->leftJoin('pools', 'pools.id', '=', 'pool_id')->leftJoin('users', 'users.id', '=', 'user_id')->get();
    }*/
}
