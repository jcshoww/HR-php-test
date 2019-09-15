<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Order;
use App\Partner;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::list()->current()->orderBy('delivery_dt', 'ASC')->get();
        $routes = ['current' => route('orders.current'), 'new' => route('orders.new'), 'delayed' => route('orders.delayed'),
        'finished' => route('orders.finished')];

        return view('order/index', compact('orders', 'routes'));
    }

    public function current()
    {
        return response()->json(Order::list()->current()->orderBy('delivery_dt', 'ASC')->get()->toArray());
    }

    public function new()
    {
        return response()->json(Order::list()->new()->take(50)->orderBy('delivery_dt', 'ASC')->get()->toArray());
    }

    public function delayed()
    {
        return response()->json(Order::list()->delayed()->take(50)->orderBy('delivery_dt', 'DESC')->get()->toArray());
    }

    public function finished()
    {
        return response()->json(Order::list()->finished()->take(50)->orderBy('delivery_dt', 'DESC')->get()->toArray());
    }

    public function edit($id)
    {
        $order = Order::relatedData()->findOrFail($id);
        $partners = Partner::get();
        $statuses = Order::STATUS;

        return view('order/edit', compact('order', 'partners', 'statuses'));
    }

    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();
        $order = Order::findOrFail($validated['id']);
        return ($order->fill($validated)->save())
          ? redirect()->route('orders.edit', [$order->id])->with('message_success', 'Заказ успешно сохранён!')
          : back()->withInput()->withErrors(['Ошибка сохранения заказа!']);
    }
}
