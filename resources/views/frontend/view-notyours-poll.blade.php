@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="table-responsive row">
            <table class="table">
                <thead class="table-striped">
                    <tr>
                        <th>{{ $pollData->id }}</th>
                        <th>{{ $pollData->question }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <style>
    </style>
@endsection