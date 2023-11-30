<?php

namespace App\Http\Controllers\Menu\Settings\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Yajra\Datatables\Datatables;

class DatatableController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isStaff');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasks = Task::with('task_type')
            ->withCount('quote_tasks')
            ->get();

        return Datatables::of($tasks)
            // Task type column.
            ->addColumn('task_type', function ($task) {
                return $task->task_type->title;
            })
            // Default cost column.
            ->editColumn('price', function ($task) {
                return '$' . number_format(($task->price / 100), 2, '.', ',');
            })
            // Count of use field.
            ->addColumn('count', function ($task) {
              // The count of how many times this task has been used on a quote.
              return $task_count = $task->quote_tasks_count;
            })
            // Add options button column.
            ->addColumn('action', function ($task) {
                // Button 1
                return '<a href="' . route('task-settings.show', $task->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
