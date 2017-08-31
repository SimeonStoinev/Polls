<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollGroups extends Model
{
    protected $table = 'poll_groups';
    protected $fillable = [
        'id', 'group_id', 'pool_id'
    ];

    public function scopeGetPollIdGroupInfo($query, $id){
        return $query->where('pool_id', $id)->leftJoin('groups', 'groups.id', '=', 'group_id');
    }


    public function scopeGetAllGroupPolls($query){
        return $query->leftJoin('groups', 'groups.id', '=', 'group_id')->leftJoin('pools', 'pools.id', '=', 'pool_id')->leftJoin('users', 'users.id', '=', 'pools.creator_id')->where('pools.status', 'active')->select('pools.id as id', 'question', 'answers', 'pools.creator_id', 'name');
    }
}
