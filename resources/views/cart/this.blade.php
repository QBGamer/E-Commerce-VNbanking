@extends('layouts.app', ['title' => 'Shopping Cart'])

@section('content')
@php
    // echo $cartItems;
    echo $subtotal = $cartItems->sum(function ($item) {
        return $item['product']['price'] * $item['quantity'];
    });
@endphp
@endsection
