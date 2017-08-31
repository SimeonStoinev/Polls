@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="padding: 0 2%;">
                <div class="panel-heading"><span style="font-size: 20px;">Dashboard</span></div>
                @foreach($allUnreadRecievedMsg as $row)
                    <span class="listed_msg" style="margin-top: 15px;display: inline-block;">
                        <a href="{{ '/message/'.$row->message_id }}">Вие получихте съобщение номер {{ $row->message_id }} от {{ $row->name }}</a>
                    </span>
                    <br/>
                @endforeach
                <ul class="grid">
                    <li class="grid-sizer"></li>
                    <li class="gutter-sizer"></li>
                    @foreach($data as $row)
                        <li class="eachpool grid-item">
                            <form class="pool" action="{{url('/')}}" method="post">
                                <div class="itemPool">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <section class="front">
                                        <h2 class="question">{{ $row->question }}</h2>
                                        <?php $c = 0; ?>
                                        @foreach(json_decode($row->answers) as $row2)
                                            <?php $c++; ?>
                                            <label class="input-group-addon">
                                                <div class="gradient">
                                                    <div><div></div></div>
                                                </div>
                                                <span>
                                                   <input type="radio" name="radiob" value="a{{ $c-1 }}"/>
                                                </span>
                                                <span class="after_radio">{{ $row2 }}</span>
                                            </label>
                                        @endforeach
                                        <div style="width: 100%;position: relative;margin-top: 15px;">
                                            @if($row->creator_id == Auth::id())

                                            @else
                                                <button class="get_id" name="submit" type="button" onclick="submit_vote($(this).parent().parent().parent().parent() , <?php echo $row->id ?>)">Гласувай</button>
                                            @endif
                                            <button class="view_results" type="button" onclick="get_results($(this).parent().parent().parent() ,<?php echo $row->id ?>)">Виж резултатите</button>
                                            <span class="from">От: {{ $row->name }}</span>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </li>
                    @endforeach
                </ul>
                <div class="paging" style="margin-bottom: 25px;">
                    @if($currPage < 2)

                    @else
                        <a href="{{ $currPage-1 }}"><span class="pageDown"></span></a>
                    @endif

                    <?php echo $paging ?>

                    @if($allPages == $currPage)

                    @else
                        <a href="{{ $currPage+1 }}"><span class="pageUp"></span></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script>
    $('.grid').masonry({
        itemSelector: '.grid-item',
        columnWidth: '.grid-sizer',
        gutter:'.gutter-sizer',
        fitWidth: true,
        percentPosition: true
    });
</script>
@endsection
