

@extends('layouts.app')

@section('content')
    <a href="">home    </a>
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/admin') }}">dashboard</a>
                {{-- inserisci navbar dell'admin --}}
            @else
                {{-- inserisci navbar del guest --}}
                <a href="{{ route('login') }}">Login</a>
                
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
    
    

@endsection



