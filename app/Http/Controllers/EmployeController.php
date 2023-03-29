<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Http\Requests\StoreEmployeRequest;
use App\Http\Requests\UpdateEmployeRequest;

class EmployeController extends Controller
{
    /**
     * Display all active employes.
     */
    public function index()
    {
        return Employe::where("status", ["ACTIVE"])->with('tasks')->paginate();
    }

    /**
     * Display all employes
     */
    public function all()
    {
        return Employe::with('tasks')->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeRequest $request)
    {
        $employe = new Employe([
            "fullname" => $request->fullname,
            "phone" => $request->phone,
            "email" => $request->email
        ]);
        $employe->save();
        return $employe;
    }

    /**
     * Display the specified resource.
     */
    public function show(Employe $employe)
    {
        return $employe->with("tasks")->find($employe->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeRequest $request, Employe $employe)
    {
        $employe->update([
            "fullname" => $request->fullname ?? $employe->fullname,
            "email" => $request->email ?? $employe->email,
            "phone" => $request->phone ?? $employe->phone,
            "status" => $request->status ?? $employe->status
        ]);
        return $employe;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employe $employe)
    {
        $pendingTasks = $employe->tasks()->where('status',"!=","FINISHED")->get();
        if (count($pendingTasks)>0){
            return response("The employe has tasks that are not finished yet", 401);
        }
        $employe->update(["status" => "INACTIVE"]);
        return ["msg" => "Employe deleted"];
    }
}
