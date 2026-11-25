@php
    $selectedId = old('task_id', $workLog->task_id ?? '');
    $selectedLabel = old('task_label', isset($workLog) ? $workLog->task->project->name . ' — ' . $workLog->task->name : '');
    $startedAt = old('started_at', isset($workLog) ? $workLog->started_at->format('Y-m-d\TH:i') : '');
    $endedAt = old('ended_at', isset($workLog) ? $workLog->ended_at->format('Y-m-d\TH:i') : '');
    $isOffice = old('is_office', isset($workLog) ? (int) $workLog->is_office : 1);
@endphp

@csrf
@if (isset($workLog))
    @method('PUT')
@endif

<label for="task-search">Задание</label>
<div class="picker" data-url="{{ route('tasks.search') }}">
    <input type="text" id="task-search" name="task_label" value="{{ $selectedLabel }}" placeholder="Начните вводить проект или задание" autocomplete="off">
    <input type="hidden" id="task-id" name="task_id" value="{{ $selectedId }}">
    <ul id="task-results"></ul>
</div>
@error('task_id')<div class="error">{{ $message }}</div>@enderror

<label for="started_at">Начало работы</label>
<input type="datetime-local" id="started_at" name="started_at" value="{{ $startedAt }}" required>
@error('started_at')<div class="error">{{ $message }}</div>@enderror

<label for="ended_at">Окончание работы</label>
<input type="datetime-local" id="ended_at" name="ended_at" value="{{ $endedAt }}" required>
@error('ended_at')<div class="error">{{ $message }}</div>@enderror

<label for="is_office">Место работы</label>
<select id="is_office" name="is_office">
    <option value="1" @selected((int) $isOffice === 1)>Офис</option>
    <option value="0" @selected((int) $isOffice === 0)>Дом</option>
</select>
@error('is_office')<div class="error">{{ $message }}</div>@enderror

<label for="comment">Комментарий</label>
<textarea id="comment" name="comment" rows="4">{{ old('comment', $workLog->comment ?? '') }}</textarea>
@error('comment')<div class="error">{{ $message }}</div>@enderror

<p>
    <button class="btn" type="submit">Сохранить</button>
    <a class="btn btn-light" href="{{ route('work-logs.index') }}">Отмена</a>
</p>

@push('scripts')
    <script src="{{ asset('js/task-select.js') }}"></script>
@endpush
