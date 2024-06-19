<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Auth;
use Exception;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::where('user_id', Auth::id())->get();
        return view('user.complaint', [
            'complaints' => $complaints
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string']
        ]);

        try{
            $complaint = new Complaint();
            $complaint->user_id = Auth::id();
            $complaint->message = $request->message;
            $complaint->save();

            return redirect()->back()->with('success', 'successfully added complaints');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
