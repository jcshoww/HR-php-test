@extends('templates.app')
@section('title','Задания')
@section('layout')
<div class="row">
    <div class="text-center sitemap">
        <ul class="list-unstyled">
            <li><a href="{{ route('weather') }}">Погода</a></li>
            <li><a href="{{ route('orders.index') }}">Заказы</a></li>
            <li><a href="{{ route('products.index') }}">Продкты</a></li>
        </ul>
    </div>
</div>
@endsection