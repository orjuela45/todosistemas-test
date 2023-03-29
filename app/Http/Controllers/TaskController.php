<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Employe;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::with("employe")->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $employe = Employe::find($request->employe_id);
        if (!$employe) return response("Employe not exist",400);
        if ($employe->status === "INACTIVE") return response("Employe is inactive",400);
        $task = $employe->tasks()->create([
            "title" => $request->title,
            "description" => $request->description,
            "execution_date" => $request->execution_date
        ]);
        return $task->with("employe")->find($task->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $task->with("employe")->find($task->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $employe = Employe::find($request->employe_id ?? $task->employe->id);
        if (!$employe) return response("Employe not exist",400);
        if ($employe->status === "INACTIVE") return response("Employe is inactive",400);
        $employe->tasks()->update([
            "title" => $request->title ?? $task->title,
            "description" => $request->description ?? $task->description,
            "execution_date" => $request->execution_date ?? $task->execution_date,
            "status" => $request->status ?? $task->status
        ]);
        
        return $task->with("employe")->find($task->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->update(["status" => "DELETED"]);
        return ["msg" => "Task deleted"];
    }
}
