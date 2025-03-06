@extends('user.layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row align-items-center min-vh-100">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-4">Informasi Spot Memancing</h1>
            <p class="lead text-muted mb-5">
                Dapatkan Informasi Mengenai Spot Potensial Memancing di Pesisir dan Sekitar kota Lhokseumawe untuk mendapatkan pengalaman memancing terbaik
            </p>
            <a href="{{ route('spot.index') }}" class="btn btn-danger px-4 py-2">
                Dapatkan Spot
            </a>
        </div>
        <div class="col-lg-6 text-center">
            <img src="{{ asset('images/logobesar.png') }}" alt="Fishing Icon" class="img-fluid">
        </div>
    </div>
</div>
@endsection
