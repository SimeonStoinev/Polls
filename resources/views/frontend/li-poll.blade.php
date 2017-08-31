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
                    <button class="get_id" name="submit" type="button" onclick="submit_vote($(this).parent().parent().parent().parent() , <?php echo $row->id ?>)">Гласувай</button>
                    <button class="view_results" type="button" onclick="get_results($(this).parent().parent().parent() ,<?php echo $row->id ?>)">Виж резултатите</button>
                    <span class="from">От: {{ $row->name }}</span>
                </div>
            </section>

            <section class="back">

            </section>
        </div>
    </form>
</li>