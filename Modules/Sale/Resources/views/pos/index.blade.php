@extends('layouts.app')

@section('title', 'POS')

@section('third_party_stylesheets')

@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">POS</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('utils.alerts')
            </div>
            <div class="col-lg-7">
                <livewire:search-product />
                <livewire:pos.product-list :categories="$product_categories" />
            </div>
            <div class="col-lg-5">
                <livewire:pos.checkout :cart-instance="'sale'" :customers="$customers" />
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $(document).ready(function() {
            window.addEventListener('showCheckoutModal', event => {
                $('#checkoutModal').modal('show');

                $('#paid_amount').maskMoney({
                    prefix: '{{ settings()->currency->symbol }}',
                    thousands: '{{ settings()->currency->thousand_separator }}',
                    decimal: '{{ settings()->currency->decimal_separator }}',
                    allowZero: true,
                    precision: 0
                });

                $('#total_amount').maskMoney({
                    prefix: '{{ settings()->currency->symbol }}',
                    thousands: '{{ settings()->currency->thousand_separator }}',
                    decimal: '{{ settings()->currency->decimal_separator }}',
                    allowZero: true,
                    precision: 0
                });

                $('#due_amount').maskMoney({
                    prefix: '{{ settings()->currency->symbol }}',
                    thousands: '{{ settings()->currency->thousand_separator }}',
                    decimal: '{{ settings()->currency->decimal_separator }}',
                    allowZero: true,
                    precision: 0
                });

                $("#paid_amount").on('keyup', function() {
                    var total_amount = parseInt($('#total_amount').attr('value'));
                    var paid_amount = parseInt($('#paid_amount').val().replace(/[^\d]/g, ''));
                    var due_amount = paid_amount - total_amount;
                    $('#due_amount').val(due_amount);
                    $('#due_amount').maskMoney('mask');
                });
                $('#paid_amount').maskMoney('mask', parseFloat($('#paid_amount').attr('value')));
                $('#total_amount').maskMoney('mask', parseFloat($('#total_amount').attr('value')));
                $('#due_amount').maskMoney('mask');
                $('#checkout-form').submit(function() {
                    var paid_amount = $('#paid_amount').val().replace(/[^\d]/g, '');
                    $('#paid_amount').val(paid_amount);
                    var total_amount = $('#total_amount').val().replace(/[^\d]/g, '');
                    $('#total_amount').val(total_amount);
                });
            });
        });
    </script>
@endpush
