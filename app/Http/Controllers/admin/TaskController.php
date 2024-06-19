<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        $roles = DB::table('role_user')->where('role_id', 3)->get();
        //dd($roles);
        return view('admin.task', [
            'tasks' => Task::all(),
            'roles' => $roles
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'integer'],
            'message' => ['required', 'string']
        ]);

        try{
            $task = new Task();
            $task->user_id = $request->user_id;
            $task->message = $request->message;
            $task->status = false;
            $task->save();

            return redirect()->back()->with('success', 'successfully added tasks');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
