<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'id', 'author_id', 'content', 'type', 'type_oftype'
    ];


    public function scopeGetMessageForRead($query, $message_id){
       return $query->leftJoin('sent_messages', 'messages.id', '=', 'message_id')->where('message_id', $message_id)->select('message_id as id', 'author_id', 'content', 'type', 'type_oftype', 'members_id', 'read_flag', 'invite_flag');
    }
}
