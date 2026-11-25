<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $term = trim((string) $request->query('q', ''));
        $like = '%' . addcslashes($term, '%_\\') . '%';

        $tasks = Task::query()
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->when($term !== '', function ($query) use ($like) {
                $query->where(function ($inner) use ($like) {
                    $inner->where('tasks.name', 'ilike', $like)
                        ->orWhere('projects.name', 'ilike', $like);
                });
            })
            ->orderBy('projects.name')
            ->orderBy('tasks.name')
            ->limit(20)
            ->get(['tasks.id', 'tasks.name as task_name', 'projects.name as project_name'])
            ->map(fn ($task) => [
                'id' => $task->id,
                'label' => $task->project_name . ' — ' . $task->task_name,
            ]);

        return response()->json($tasks);
    }
}
