@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Моите анкети</h2>

        <div class="table-responsive row">
            <table class="table">
                <thead class="table-striped">
                <?php $c=0;?>
                @foreach($pollsData as $row)
                    <tr>
                        <th class="question">
                            {{ $row->question }}
                        </th>
                        <th>
                            Гласували:
                            @if($allItemsPerPoll[$c] == null)
                                0
                            @else
                                {{ $allItemsPerPoll[$c] }}
                            @endif
                        </th>
                        <th>
                            @if($row->status == 'active')
                                Статус: <span class="status_span">Активен</span>
                            @elseif($row->status == 'draft')
                                Статус: <span class="status_span">Скица</span>
                            @else
                                Статус: <span class="status_span">Затворен</span>
                            @endif
                        </th>
                        <th>
                            @if($row->for_users == 'all')
                                Достъп: Всички
                            @elseif($row->for_users == 'group')
                                Достъп: Група
                            @elseif($row->for_users == 'public')
                                Публична
                            @endif
                        </th>
                        <th>
                            @if($row->status == 'draft')
                                <a href="{{ '/polls/create/'.$row->id }}">
                                    <button class="core-btn" type="button">Редактирай</button>
                                </a>
                            @else
                                <a href="{{ '/polls/create/'.$row->id }}">
                                    <button class="core-btn" type="button">Прегледай</button>
                                </a>
                            @endif
                        </th>
                    </tr>
                    <?php $c++;?>
                @endforeach
                </thead>
            </table>
        </div>
    </div>
    <style>
        .row{
            margin-top: 1%;
        }
        .core-btn{
            margin: 10px 0 2px 0;
        }
    </style>
@endsection