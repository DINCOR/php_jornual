<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Журнал нагрузки</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f6f8; color: #222; }
        header { background: #1f3a5f; color: #fff; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        header a { color: #fff; text-decoration: none; }
        main { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
        .card { background: #fff; padding: 20px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border-bottom: 1px solid #e3e6ea; text-align: left; vertical-align: top; }
        label { display: block; margin: 12px 0 4px; font-weight: bold; }
        input[type=text], input[type=email], input[type=password], input[type=datetime-local], textarea, select { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #c5cbd3; border-radius: 4px; }
        .btn { display: inline-block; padding: 8px 14px; background: #1f3a5f; color: #fff; border: 0; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn-danger { background: #b3261e; }
        .btn-light { background: #6b7684; }
        .error { color: #b3261e; font-size: 13px; margin-top: 4px; }
        .status { background: #e2f4e5; padding: 10px; border-radius: 4px; margin-bottom: 16px; }
        .inline { display: inline; }
        .picker { position: relative; }
        .picker ul { position: absolute; left: 0; right: 0; z-index: 10; margin: 0; padding: 0; list-style: none; background: #fff; border: 1px solid #c5cbd3; max-height: 240px; overflow-y: auto; display: none; }
        .picker li { padding: 8px; cursor: pointer; }
        .picker li:hover { background: #eef2f7; }
        .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .pagination { margin-top: 16px; }
    </style>
</head>
<body>
<header>
    <a href="{{ url('/') }}"><strong>Журнал нагрузки</strong></a>
    @auth
        <div>
            {{ auth()->user()->name }}
            <form class="inline" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-light" type="submit">Выйти</button>
            </form>
        </div>
    @endauth
</header>
<main>
    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif
    @yield('content')
</main>
@stack('scripts')
</body>
</html>
