<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Renewal;
use Exception;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = Renewal::all();
        return view('admin.periods', [
            'periods' => $periods
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'length' => ['required', 'integer'],
            'description' => ['required'],
            'price' => ['required', 'numeric']
        ]);

        try{
            $period = new Renewal();
            $period->length = $request->length;
            $period->description = $request->description;
            $period->price = $request->price;
            $period->save();

            return redirect()->back()->with('success', 'successfully added a period');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'period_id' => ['required', 'integer'],
            'length' => ['required', 'integer'],
            'description' => ['required'],
            'price' => ['required', 'numeric']
        ]);

        try{

            $period = Renewal::find($request->period_id);
            if(is_null($period))
            {
                return redirect()->back()->with('error', 'period not found');
            }
            $period->length = $request->length;
            $period->description = $request->description;
            $period->price = $request->price;
            $period->save();

            return redirect()->back()->with('success', 'successfully added a period');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
