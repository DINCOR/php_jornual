@extends('layout')

@section('content')
<div class="card">
    <div class="top">
        <h2>Мой журнал нагрузки</h2>
        <a class="btn" href="{{ route('work-logs.create') }}">Добавить запись</a>
    </div>
    <table>
        <thead>
        <tr>
            <th>Начало</th>
            <th>Окончание</th>
            <th>Длительность</th>
            <th>Место</th>
            <th>Проект</th>
            <th>Задание</th>
            <th>Комментарий</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse ($workLogs as $log)
            <tr>
                <td>{{ $log->started_at->format('d.m.Y H:i') }}</td>
                <td>{{ $log->ended_at->format('d.m.Y H:i') }}</td>
                <td>{{ $log->started_at->diff($log->ended_at)->format('%H:%I') }}</td>
                <td>{{ $log->is_office ? 'Офис' : 'Дом' }}</td>
                <td>{{ $log->task->project->name }}</td>
                <td>{{ $log->task->name }}</td>
                <td>{{ $log->comment }}</td>
                <td style="white-space: nowrap;">
                    <a class="btn" href="{{ route('work-logs.edit', $log->id) }}">Изменить</a>
                    <form class="inline" method="POST" action="{{ route('work-logs.destroy', $log->id) }}" onsubmit="return confirm('Удалить запись?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8">Записей пока нет.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $workLogs->links() }}</div>
</div>
@endsection
