@extends('admin.layouts.base')
@section('title', 'Pesanan Selesai')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pesanan Pending</h1>

    @include('admin.orders.table', ['orders' => $orders])
</div>
@endsection
