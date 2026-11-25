@extends('layout')

@section('content')
<div class="card">
    <h2>Редактирование записи</h2>
    <form method="POST" action="{{ route('work-logs.update', $workLog->id) }}">
        @include('work-logs._form')
    </form>
</div>
@endsection
