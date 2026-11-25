<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('users')->insert([
            'name' => 'Иван Петров',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $projects = [];
        for ($i = 1; $i <= 50; $i++) {
            $projects[] = ['name' => 'Проект ' . $i, 'created_at' => $now, 'updated_at' => $now];
        }
        DB::table('projects')->insert($projects);

        $projectIds = DB::table('projects')->pluck('id')->all();

        $tasks = [];
        for ($i = 1; $i <= 5000; $i++) {
            $tasks[] = [
                'project_id' => $projectIds[array_rand($projectIds)],
                'name' => 'Задание ' . $i,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        foreach (array_chunk($tasks, 1000) as $chunk) {
            DB::table('tasks')->insert($chunk);
        }

        $userId = DB::table('users')->value('id');
        $taskIds = DB::table('tasks')->limit(100)->pluck('id')->all();

        $logs = [];
        for ($i = 1; $i <= 30; $i++) {
            $start = now()->subDays($i)->setTime(9, 0);
            $logs[] = [
                'user_id' => $userId,
                'task_id' => $taskIds[array_rand($taskIds)],
                'started_at' => $start,
                'ended_at' => $start->copy()->addHours(rand(1, 8)),
                'is_office' => (bool) rand(0, 1),
                'comment' => 'Комментарий ' . $i,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('work_logs')->insert($logs);
    }
}
