<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Group extends Model
{
    protected $table = 'groups';
    protected $fillable = [
        'id', 'title', 'description', 'creator_id', 'thumbnail', 'slug', 'category', 'status'
    ];

    public function scopeGetMineGroups($query, $id){
        return $query->where('creator_id', $id);
    }

    public function scopeGetPartGroups($query, $id){
        return $query->leftJoin('group_members', 'group_id', '=', 'groups.id')->where('user_id', $id);
    }

    public function scopeGetGroup($query, $id){
        return $query->where('id', $id);
    }

    public function scopeGetAllGroupPolls($query){
        return $query->leftJoin('poll_groups', 'groups.id', '=', 'group_id')->leftJoin('pools', 'pools.id', '=', 'pool_id')->where('pools.status', 'active')->leftJoin('users', 'users.id', '=', 'pools.creator_id')->select('pools.id as id', 'question', 'answers', 'pools.creator_id', 'name');
    }
}
