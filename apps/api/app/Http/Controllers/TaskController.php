<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Task::query();

        // 🔍 Search (gunakan regex agar bisa case-insensitive)
        if ($request->filled('search')) {
            $search = $request->input('search');
            
            $query->where(function ($q) use ($search) {
                $q->whereLike('title', '%'.$search.'%', true)
                  ->orWhereLike('status', '%'.$search.'%', true)
                  ->orWhereLike('priority', '%'.$search.'%', true);
            });
        }

        // 📊 Filtering optional (misal berdasarkan status)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 🔽 Sorting
        $sortBy = $request->query('sortBy', 'created_at');
        $sortOrder = $request->query('sortOrder', 'desc'); // 'asc' / 'desc'
        $query->orderBy($sortBy, $sortOrder);

        // 📄 Pagination
        $perPage = (int) $request->query('perPage', 5);
        $page = (int) $request->query('page', 1);

        $tasks = $query->paginate($perPage, ['*'], 'page', $page);

        // 📦 Response format (disamakan dengan frontend)
        return response()->json([
            'data' => $tasks->items(),
            'meta' => [
                'total' => $tasks->total(),
                'page' => $tasks->currentPage(),
                'perPage' => $tasks->perPage(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'status' => 'required|integer',
            'priority' => 'required|integer',
        ]);

        $task = Task::create($data);

        return response()->json([
            'message' => 'Task created successfully.',
            'data' => $task,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string',
            'status' => 'required|integer',
            'priority' => 'required|integer',
        ]);

        $task->update($data);

        return response()->json([
            'message' => 'Task updated successfully.',
            'data' => $task,
        ]);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully.']);
    }
}
