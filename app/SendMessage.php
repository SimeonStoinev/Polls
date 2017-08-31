<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class SendMessage extends Model
{
    protected $table = 'sent_messages';
    protected $fillable = [
        'id', 'message_id', 'members_id', 'read_flag', 'invite_flag'
    ];

    public function scopeGetAllReadSentMsg($query){
        return $query->where('read_flag', true)->leftJoin('messages', 'messages.id', '=', 'message_id')->leftJoin('users', 'users.id', '=', 'members_id')->where('author_id', Auth::user()['id'])->get();
    }

    public function scopeGetAllUnreadSentMsg($query){
        return $query->where('read_flag', null)->leftJoin('messages', 'messages.id', '=', 'message_id')->leftJoin('users', 'users.id', '=', 'members_id')->where('author_id', Auth::user()['id'])->get();
    }

    public function scopeGetAllReadRecievedMsg($query){
        return $query->where('read_flag', true)->leftJoin('messages', 'messages.id', '=', 'message_id')->leftJoin('users', 'users.id', '=', 'author_id')->where('members_id', Auth::user()['id'])->get();
    }

    public function scopeGetAllUnreadRecievedMsg($query){
        return $query->where('read_flag', null)->leftJoin('messages', 'messages.id', '=', 'message_id')->leftJoin('users', 'users.id', '=', 'author_id')->where('members_id', Auth::user()['id'])->get();
    }

    public function scopeGetMessage($query, $id){
        return $query->leftJoin('messages', 'messages.id', '=', 'message_id')->where('message_id', $id);
    }
}
