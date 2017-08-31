@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Моите групи</h2>
        <div class="table-responsive row">
            <table class="table">
                <thead class="table-striped">
                @foreach($groupsData as $row)
                    <tr>
                        <th>
                            <a href="{{ '/group/'.$row->id }}"> {{ $row->title }} </a>
                        </th>
                        <th>
                            @if($row->category == 'news')
                                Категория: <span class="status_span"> Новини</span>
                            @elseif($row->category == 'school')
                                Категория: <span class="status_span">Училище</span>
                            @elseif($row->category == 'work')
                                Категория: <span class="status_span">Работа</span>
                            @elseif($row->category == 'entertainment')
                                Категория: <span class="status_span">Забавление</span>
                            @elseif($row->category == 'celebrities')
                                Категория: <span class="status_span">Знаменитости</span>
                            @elseif($row->category == 'politics')
                                Категория:<span class="status_span"> Политика</span>
                            @elseif($row->category == 'business')
                                Категория:<span class="status_span"> Бизнес</span>
                            @elseif($row->category == 'music')
                                Категория:<span class="status_span"> Музика</span>
                            @else
                                Категория: <span class="status_span"> Друга</span>
                            @endif
                        </th>
                        <th>
                            @if($row->status == 'active')
                                Статус: <span class="status_span">Активна</span>
                            @elseif($row->status == 'closed')
                                Статус: <span class="status_span">Затворена</span>
                            @endif
                        </th>
                        <th>
                            <a href="{{ '/groups/create/'.$row->id }}">
                                <button class="core-btn" type="submit">Редактирай</button>
                            </a>
                        </th>
                    </tr>
                @endforeach
                </thead>
            </table>
        </div>
    </div>
    <style>
        .table{
            margin-top: 1%;
        }
        .core-btn{
            margin: 10px 0 2px 0;
        }
    </style>
@endsection