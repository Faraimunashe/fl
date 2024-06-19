<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Application;
use App\Models\Permit;
use App\Models\Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use PDF;

class DashboardController extends Controller
{
    public function index()
    {
        $acc = Account::where('user_id', Auth::id())->first();
        $permit = Permit::where('user_id', Auth::id())->first();
        $application = Application::where('user_id', Auth::id())->first();
        return view('user.dashboard', [
            'acc' => $acc,
            'permit' => $permit,
            'application' => $application
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try{

            $image = Image::where('user_id', Auth::id())->first();
            if(is_null($image))
            {

                $imageName = time().'.'.$request->image->extension();

                $request->image->move(public_path('images'), $imageName);

                $image = new Image();
                $image->user_id = Auth::id();
                $image->image = $imageName;
                $image->save();
            }else{
                $imageName = time().'.'.$request->image->extension();

                $request->image->move(public_path('images'), $imageName);

                $image->image = $imageName;
                $image->save();
            }

            return redirect()->back()->with('success','You have successfully upload image.');
        }catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function generatePDF()
    {
        $permit = Permit::where('user_id', Auth::id())->first();
        if(is_null($permit))
        {
            return redirect()->back()->with('error', 'Permit details not found!');
        }

        if(!$permit->valid || strtotime($permit->expiry_date) < time())
        {
            return redirect()->back()->with('error', 'Permit cannot be printed in this state!');
        }

        $account = Account::where('user_id', Auth::id())->first();
        $img = Image::where('user_id', Auth::id())->first();
        $imagePath = public_path('images/'.$img->image);

        $pdf = PDF::loadView('pdf.permit', [
            'permit' => $permit,
            'account' => $account,
            'userImage' => $imagePath
        ]);
        $pdf->setOption('images', true);
        return $pdf->download('permit.pdf');
    }

    public function generateIMG()
    {
        $permit = Permit::where('user_id', Auth::id())->first();
        if(is_null($permit))
        {
            return redirect()->back()->with('error', 'Permit details not found!');
        }

        if(!$permit->valid || strtotime($permit->expiry_date) < time())
        {
            return redirect()->back()->with('error', 'Permit cannot be printed in this state!');
        }

        $account = Account::where('user_id', Auth::id())->first();
        $img = Image::where('user_id', Auth::id())->first();

        return view('pdf.image', [
            'permit' => $permit,
            'account' => $account,
            'img' => $img
        ])->render();

    }
}
