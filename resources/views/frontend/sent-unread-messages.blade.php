@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="list_messages">

            <h2>Изпратени непрочетени съобщения</h2>

            @foreach($allUnreadSentMsg as $row)
                <span class="listed_msg">
                    <a href="{{ '/message/'.$row->message_id }}">
                        Вие изпратихте съобщение номер {{ $row->message_id }} до {{ $row->name }} със съдържание:
                        <br/> "{{ $row->content }}"
                    </a>
                </span>
                <br/>
            @endforeach
        </div>
    </div>
    <style>

    </style>
@endsection