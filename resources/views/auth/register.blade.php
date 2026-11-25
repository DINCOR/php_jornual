@extends('layout')

@section('content')
<div class="card" style="max-width: 420px; margin: 0 auto;">
    <h2>Регистрация</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label for="name">Имя сотрудника</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')<div class="error">{{ $message }}</div>@enderror

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')<div class="error">{{ $message }}</div>@enderror

        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>
        @error('password')<div class="error">{{ $message }}</div>@enderror

        <label for="password_confirmation">Повторите пароль</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <p><button class="btn" type="submit">Зарегистрироваться</button>
        <a href="{{ route('login') }}">Вход</a></p>
    </form>
</div>
@endsection
