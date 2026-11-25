@extends('layout')

@section('content')
<div class="card">
    <h2>Новая запись</h2>
    <form method="POST" action="{{ route('work-logs.store') }}">
        @include('work-logs._form')
    </form>
</div>
@endsection
