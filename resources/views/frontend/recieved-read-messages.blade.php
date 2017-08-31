@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="list_messages">

            <h2>Получени непрочетени съобщения</h2>

            @foreach($allReadRecievedMsg as $row)
                <span class="listed_msg">
                    <a href="{{ '/message/'.$row->message_id }}">
                        Вие получихте съобщение номер {{ $row->message_id }} от {{ $row->name }} със съдържание:
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