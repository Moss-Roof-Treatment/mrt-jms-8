@extends('layouts.welcome')

@section('title', '- Welcome')

@section('content')
<section>
    <div class="container py-5">
        <div class="jumbotron bg-light mt-5">
            <div class="pt-5"></div>
            <div class="pt-5"></div>
            <h1 class="display-3 mt-5 mb-0">Qontrol</h1>
            <h2 class="ml-2">By LMC Consulting</h2>
            <h5 class="ml-2">Version {{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</h5>
        </div>
    </div> {{-- container --}}
</section> {{-- section --}}
@endsection