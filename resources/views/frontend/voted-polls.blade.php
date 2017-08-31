@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Гласувани анкети</h2>
    <div class="table-responsive row">
        <table class="table" style="margin-top: 1%;">
            <thead class="table-striped">
            <tr>
                <th>Въпрос:</th>
                <th></th>
                <th>От:</th>
            </tr>
            </thead>
            <tbоdy>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->question }}</td>
                        <td> </td>
                        <td>{{ $item->name }}</td>
                    </tr>
                @endforeach
            </tbоdy>
        </table>
    </div>
</div>
<style>
    .table-responsive{
        margin: 0 auto;
    }
</style>
@endsection