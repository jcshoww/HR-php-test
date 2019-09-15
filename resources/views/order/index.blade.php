@extends('templates.app')
@section('title','Список заказов')
@section('footer-scripts')
    <script src="{{ url('js/vue.js') }}"></script>
    <script src="{{ url('js/vue-resource.js') }}"></script>
    <script>
        new Vue({
            el: '#orders',
            data: {
                orders: <?php echo $orders->toJson() ?>,
                routes: <?php echo json_encode($routes) ?>,
                activeTab: 'current',
            },
            methods: {
                setActiveTab: function (tab) {
                    let url = this.routes[tab];
                    this.activeTab = tab;
                    this.getOrders(url);
                },
                isActive: function (tab) {
                    return this.activeTab === tab;
                },
                getOrders: function (url) {
                    this.$http
                        .post(url, { _token: "{{ csrf_token() }}"})
                        .then(function (response) {
                            this.orders = response.body;
                        }, console.log)
                        .catch(function (error) {
                            console.log(error);
                            setTimeout(this.getOrdersByTab(tab), 1000);
                        });
                }
            },
        });
    </script>
@endsection
@section('layout')
<section id="orders" class="orders">
    <h2>Заказы</h2>
    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item orders__tab" :class="{ active:isActive('current') }">
                <a class="nav-link" @click="setActiveTab('current')">Текущие</a>
            </li>
            <li class="nav-item orders__tab" :class="{ active:isActive('new') }">
                <a class="nav-link" @click="setActiveTab('new')">Новые</a>
            </li>
            <li class="nav-item orders__tab" :class="{ active:isActive('delayed') }">
                <a class="nav-link" @click="setActiveTab('delayed')">Просроченные</a>
            </li>
            <li class="nav-item orders__tab" :class="{ active:isActive('finished') }">
                <a class="nav-link" @click="setActiveTab('finished')">Выполненные</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Партнер</th>
                    <th>Стоимость</th>
                    <th>Состав заказа</th>
                    <th>Статус заказа</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="orders.length > 0" v-for="(order, index) in orders">
                    <th scope="row"><a :href="order.edit_route">@{{ order.id }}</a></th>
                    <td>@{{ order.partner.name }}</td>
                    <td>@{{ order.products_price }}</td>
                    <td>
                        <dl v-if="order.products" class="dl-horizontal" v-for="(product, index) in order.products">
                            <dt>@{{ product.name }}</dt>
                            <dd>Цена: @{{ product.price }} Количество: @{{ product.pivot.quantity }}</dd>
                        </dl>
                    </td>
                    <td>@{{ order.status_description }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection