@extends('templates.app')
@section('title','Заказ #' . $order->id)
@section('layout')
<section id="order" class="row">
    <div class="container">
        <h2>Заказ # {{ $order->id }}</h2>
        <div class="row">
            <form class="order form-horizontal" action="{!! route('orders.store') !!}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $order->id }}">
                <div class="form-group">
                    <label for="emailInput" class="col-sm-2 control-label">Email клиента</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" 
                            id="emailInput" name="client_email" placeholder="Email" value="{{ $order->client_email }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="partnerInput" class="col-sm-2 control-label">Партнер</label>
                    <div class="col-sm-10">
                    <select class="form-control" id="partnerInput" name="partner_id">
                        @foreach($partners as $partner)
                            <option value="{{ $partner->id }}" {{ $partner->id == $order->partner_id ? 'selected' : '' }}>
                                {{ $partner->name }}
                            </option>
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="statusInput" class="col-sm-2 control-label">Статус</label>
                    <div class="col-sm-10">
                    <select class="form-control" id="statusInput" name="status">
                        @foreach($statuses as $status)
                            <option value="{!! $status['id'] !!}" {!! $status['id'] == $order->status ? 'selected' : '' !!}>
                                {!! $status['label'] !!}
                            </option>
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="productsList" class="col-sm-2 control-label">Продукты</label>
                    <div class="col-sm-10" id="productsList">
                        @foreach($order->products as $product)
                            <div class="col-sm-2 order__product-block">
                                <div class="card order__product-card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Количество: {{ $product->pivot->quantity }}</h6>
                                        <p class="card-text">Цена за единицу: {{ $product->price }} </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="totalPrice" class="col-sm-2 control-label">На общую стоимость</label>
                    <div class="col-sm-2 order__total-price" id="totalPrice">
                        <div>
                            {{ $order->products_price }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Сохранить</button>
                    </div>
                </div>
                @if(count($errors) > 0)
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                            @foreach($errors->all() as $error)
                                <div class="bg-danger order__error">{{$error}}</div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</section>
@endsection