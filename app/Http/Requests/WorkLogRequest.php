<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class WorkLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_id' => ['required', 'integer', 'exists:tasks,id'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['required', 'date', 'after:started_at'],
            'is_office' => ['required', 'boolean'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->hasAny(['started_at', 'ended_at'])) {
                return;
            }

            $start = Carbon::parse($this->input('started_at'));
            $end = Carbon::parse($this->input('ended_at'));

            if ($end->greaterThan($start->copy()->addHours(8))) {
                $validator->errors()->add('ended_at', 'Разница между началом и окончанием не может превышать 8 часов.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'task_id.required' => 'Выберите задание.',
            'task_id.exists' => 'Выбранное задание не найдено.',
            'started_at.required' => 'Укажите дату и время начала.',
            'ended_at.required' => 'Укажите дату и время окончания.',
            'ended_at.after' => 'Дата окончания должна быть больше даты начала.',
            'is_office.required' => 'Укажите место работы.',
            'comment.max' => 'Комментарий не должен превышать 2000 символов.',
        ];
    }
}
