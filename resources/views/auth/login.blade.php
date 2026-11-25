@extends('layout')

@section('content')
<div class="card" style="max-width: 420px; margin: 0 auto;">
    <h2>Вход</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')<div class="error">{{ $message }}</div>@enderror

        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>
        @error('password')<div class="error">{{ $message }}</div>@enderror

        <label><input type="checkbox" name="remember" value="1" style="width:auto;"> Запомнить меня</label>

        <p><button class="btn" type="submit">Войти</button>
        <a href="{{ route('register') }}">Регистрация</a></p>
    </form>
</div>
@endsection
