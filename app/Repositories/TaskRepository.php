<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements TaskRepositoryInterface
{
    public function get(array $request = [])
    {
        $query = Task::query();
        $query->where('user_id', Auth::user()->id);
        if (isset($request['status'])) {
            $query->where('status', $request['status']);
        }
        if (isset($request['due_date'])) {
            $query->where('due_date', $request['due_date']);
        }
        if (isset($request['priority'])) {
            $query->where('priority', $request['priority']);
        }
        if (isset($request['notes'])) {
            $query->has('notes');
        }
        return $query->withCount('notes')
            ->orderByRaw("FIELD(priority, 'High', 'Medium', 'Low')")
            ->orderByDesc("notes_count")
            ->paginate();
    }

    public function create(array $details)
    {
        return Task::create($details);
    }

}
