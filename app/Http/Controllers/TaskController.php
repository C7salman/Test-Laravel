<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tasks = Task::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($tasks);
    }

    public function store(TaskStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $task = Task::create([
            'user_id' => $request->user()->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'due_date' => $data['due_date'] ?? null,
            'completed' => false,
        ]);

        return response()->json($task, 201);
    }

    public function update(TaskUpdateRequest $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);
        $data = $request->validated();
        $task->fill($data);
        $task->save();

        return response()->json($task);
    }

    public function toggle(Request $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);
        $task->completed = ! $task->completed;
        $task->save();

        return response()->json($task);
    }

    public function destroy(Request $request, Task $task): JsonResponse
    {
        $this->authorize('delete', $task);
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }
}