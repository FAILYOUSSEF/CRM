<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Traits\Filterable;
use Illuminate\Http\Request;
 
class TaskController extends Controller {
    use Filterable;

    public function index(Request $request) {
        // Build query with advanced filtering
        $query = Task::where('employee_id', auth()->id())
            ->with('project')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->input('search');
                $q->where(function ($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('priorite'), fn($q) => $q->where('priorite', $request->input('priorite')))
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('date_debut', '>=', $request->input('date_from')))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('date_fin', '<=', $request->input('date_to')));

        $tasks = $query->latest()->paginate(15)->withQueryString();

        // Prepare filter options for the view
        $filterOptions = [
            'status' => ['à faire', 'en cours', 'terminé'],
            'priority' => ['faible', 'moyenne', 'haute'],
        ];

        return view('employee.tasks.index', compact('tasks', 'filterOptions'));
    }
    public function show(Task $task) {
        abort_if($task->employee_id !== auth()->id(), 403);
        return view('employee.tasks.show', compact('task'));
    }
    public function update(Request $request, Task $task) {
        abort_if($task->employee_id !== auth()->id(), 403);
        $request->validate(['status'=>'required|in:à faire,en cours,terminé','commentaire'=>'nullable']);
        $task->update($request->only('status','commentaire'));
        return back()->with('success','Task updated.');
    }
}