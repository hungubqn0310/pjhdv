<!-- resources/views/payments/index.blade.php -->
@extends('layouts.layout')

@section('content')
    <h1>Danh Sách Thanh Toán</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã đơn hàng</th>
                <th>Phương thức thanh toán</th>
                <th>Trạng thái thanh toán</th>
                <th>Tổng tiền</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->order_id }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>{{ $payment->payment_status }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>
                        <a href="{{ url('/payments/' . $payment->id) }}" class="btn btn-info">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
