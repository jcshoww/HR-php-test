@extends('templates.app')
@section('title','Погода')
@section('layout')
<div class="row">
    <div class="col-md-4 col-sm-offset-4">
        <h1>Погода в Брянске</h1>
        <dl class="dl-horizontal">
            <dt>Температура</dt><dd>{{ $weather['temperature'] }}</dd>
            <dt>Ветер</dt><dd>{{ $weather['wind'] . ' м/с' }}</dd>
            <dt>Давление</dt><dd>{{ $weather['pressure'] . ' мм рт. ст.' }}</dd>
            <dt>Влажность</dt><dd>{{ $weather['humidity'] . ' %' }}</dd>
        </dl>
    </div>
</div>
@endsection