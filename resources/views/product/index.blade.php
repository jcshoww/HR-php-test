@extends('templates.app')
@section('title','Список продуктов')
@section('footer-scripts')
    <script src="{{ url('js/vue.js') }}"></script>
    <script src="{{ url('js/vue-resource.js') }}"></script>
    <script>
        new Vue({
            el: '#products',
            methods: {
                changePrice: function (id) {
                    this.$http
                        .post('<?php echo route('products.changePrice') ?>', { _token: "{{ csrf_token() }}", id: id, price: event.target.value})
                        .then(function (response) {
                            if(response) {
                                alert('Цена успешно изменена');
                            } else {
                                alert('Ошибка при изменении цены');
                            }
                        }, console.log)
                        .catch(function (error) {
                            alert(error);
                        });
                }
            },
        });
    </script>
@endsection
@section('layout')
<section id="products" class="products">
    <h2>Продукты</h2>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Поставщик</th>
                    <th>Цена</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->vendor->name }}</td>
                        <td><input name="price" value="{{ $product->price }}" @change="changePrice({{ $product->id }})"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
</section>
@endsection