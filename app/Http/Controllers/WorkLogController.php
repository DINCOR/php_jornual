<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkLogRequest;
use App\Models\WorkLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkLogController extends Controller
{
    public function index(): View
    {
        $workLogs = WorkLog::with('task.project')
            ->where('user_id', auth()->id())
            ->orderByDesc('started_at')
            ->paginate(20);

        return view('work-logs.index', compact('workLogs'));
    }

    public function create(): View
    {
        return view('work-logs.create');
    }

    public function store(WorkLogRequest $request): RedirectResponse
    {
        WorkLog::create($request->validated() + ['user_id' => auth()->id()]);

        return redirect()->route('work-logs.index')->with('status', 'Запись добавлена.');
    }

    public function edit(int $id): View
    {
        $workLog = $this->findOwned($id);

        return view('work-logs.edit', compact('workLog'));
    }

    public function update(WorkLogRequest $request, int $id): RedirectResponse
    {
        $this->findOwned($id)->update($request->validated());

        return redirect()->route('work-logs.index')->with('status', 'Запись обновлена.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->findOwned($id)->delete();

        return redirect()->route('work-logs.index')->with('status', 'Запись удалена.');
    }

    private function findOwned(int $id): WorkLog
    {
        return WorkLog::with('task.project')
            ->where('user_id', auth()->id())
            ->findOrFail($id);
    }
}
