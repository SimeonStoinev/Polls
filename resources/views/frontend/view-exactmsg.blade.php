@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="msg_keeper">
            @if($type != 'message' && $invite_flag =='pending')

            {{ Form::open(array('url' => 'message/'.$message_id, 'method' => 'post'))}}

            @endif

            Вие получихте съобщение номер {{ $message_id }}: <br/>
            <span style="font-weight: bold;">{{$content}}</span> <br/>

                <label>
                    <input type="hidden" name="read_flag" value="{{ $read_flag }}"/>
                </label>

            @if($type == 'invite' && $invite_flag == 'pending')
                <input type="hidden" name="from" value="{{ $author_id }}">
                <label>
                    <input type="radio" name="invite_flag" value="accepted"> Приемам
                </label>
                <label>
                    <input type="radio" name="invite_flag" value="declined"> Отхвърлям
                </label>
                <br/>
                <button type="submit" class="core-btn">Изпрати</button>

            {{ Form::close() }}
            @elseif($type == 'invite' && $invite_flag != 'pending' )
            Тази покана е
                @if($invite_flag == 'accepted')
                    приета.
                @elseif($invite_flag == 'declined')
                    отхвърлена.
                @endif
            @endif

        </div>
    </div>
    <style>
        .msg_keeper{
            margin-top: 1%;
            text-align: center;
            font-size: 16px;
        }
    </style>
@endsection