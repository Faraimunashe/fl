<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Permit;
use App\Models\Renewal;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $applications = Application::join('accounts', 'accounts.user_id', '=', 'applications.user_id')
            ->where('applications.status', 0)
            ->select('applications.id','applications.payment', 'applications.status', 'applications.renewal_id', 'applications.created_at', 'accounts.fname', 'accounts.lname', 'accounts.sex', 'accounts.natid')
            ->get();
        return view('admin.dashboard', [
            'applications' => $applications
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'application_id' => ['required', 'integer'],
            'status' => ['required', 'integer']
        ]);

        try{
            $app = Application::find($request->application_id);

            if(!is_null($app))
            {
                if($request->status == 1)
                {
                    //dd(rand(900000,999999));
                    $renewal = Renewal::find($app->renewal_id);
                    $date = Carbon::now();
                    $date->addMonths($renewal->length);

                    $app->status = $request->status;
                    $app->save();



                    $permit = new Permit();
                    $permit->user_id = $app->user_id;
                    $permit->reference = rand(900000,999999);
                    $permit->renewed_at = now();
                    $permit->expiry_date = $date;
                    $permit->valid = true;
                    $permit->save();
                }else{
                    $app->status = $request->status;
                    $app->save();
                }

                return redirect()->back()->with('success', 'Successfully updated ');

            }
            return redirect()->back()->with('error', 'Could not locate application');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
