<?php

namespace App\Http\Controllers\officer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Auth;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->where('status', 0)->get();
        return view('officer.dashboard', [
            'tasks' => $tasks
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'task_id' => ['required', 'integer'],
            'status' => ['required', 'integer']
        ]);
        try{
            $status = false;
            if($request->status == 1)
            {
                $status = True;
            }
            $task = Task::find($request->task_id);
            $task->status = $status;
            $task->save();

            return redirect()->back()->with('success', 'successfully updated task');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
