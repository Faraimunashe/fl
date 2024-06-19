<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permit;
use Exception;
use Illuminate\Http\Request;

class PermitsController extends Controller
{
    public function index(Request $request)
    {
        $permits = Permit::join('accounts', 'accounts.user_id', '=', 'permits.user_id')
            ->select('permits.id', 'permits.reference', 'permits.valid', 'permits.user_id', 'permits.expiry_date', 'accounts.fname', 'accounts.lname')
            ->get();
        if($request->method() == "POST")
        {
            $permits = Permit::join('accounts', 'accounts.user_id', '=', 'permits.user_id')
            ->where('permits.reference', '=', $request->search)
            ->select('permits.id', 'permits.reference', 'permits.valid', 'permits.user_id', 'permits.expiry_date', 'accounts.fname', 'accounts.lname')
            ->get();
        }
        return view('admin.permits', [
            'permits' => $permits
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'permit_id' => ['required', 'integer'],
            'option' => ['required', 'integer']
        ]);

        try{
            $permit = Permit::find($request->permit_id);
            if($request->option == 1)
            {
                $permit->valid = true;
            }else{
                $permit->valid = false;
            }

            $permit->save();
            return redirect()->back()->with('success', 'Successfully updated permit');

        }catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
