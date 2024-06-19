<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Paynowlog;
use App\Models\Permit;
use App\Models\Renewal;
use App\Models\Transaction;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {

        $application = Application::where('user_id', Auth::id())->first();
        if(!is_null($application))
        {
            return redirect()->back()->with('error', 'You already applied for a permit!');
        }
        $periods = Renewal::all();
        return view('user.application', [
            'periods' => $periods
        ]);
    }

    public function apply(Request $request)
    {
        $request->validate([
            'renewal' => ['required', 'integer'],
            'email' => ['email', 'required'],
            'phone' => ['required', 'digits:10', 'starts_with:07']
        ]);

        try{
            $renewal = Renewal::find($request->renewal);

            $application = Application::where('user_id', Auth::id())->first();
            if(!is_null($application))
            {
                return redirect()->back()->with('error', 'You have a permit application pending!');
            }

            $wallet = "ecocash";

            //get all data ready
            $email = $request->email;
            $phone = $request->phone;
            $amount = $renewal->price;

            /*determine type of wallet*/
            if (strpos($phone, '071') === 0) {
                $wallet = "onemoney";
            }

            $paynow = new \Paynow\Payments\Paynow(
                "11336",
                "1f4b3900-70ee-4e4c-9df9-4a44490833b6",
                route('user-apply'),
                route('user-apply'),
            );

            // Create Payments
            $invoice_name = "permit-application-" . time();
            $payment = $paynow->createPayment($invoice_name, $email);

            $payment->add("Zimparks Permits", $amount);

            $response = $paynow->sendMobile($payment, $phone, $wallet);


            // Check transaction success
            if ($response->success()) {

                $timeout = 9;
                $count = 0;

                while (true) {
                    sleep(3);
                    // Get the status of the transaction
                    // Get transaction poll URL
                    $pollUrl = $response->pollUrl();
                    $status = $paynow->pollTransaction($pollUrl);


                    //Check if paid
                    if ($status->paid()) {
                        // Yay! Transaction was paid for
                        // You can update transaction status here
                        // Then route to a payment successful
                        $info = $status->data();

                        $paynowdb = new Paynowlog();
                        $paynowdb->reference = $info['reference'];
                        $paynowdb->paynow_reference = $info['paynowreference'];
                        $paynowdb->amount = $info['amount'];
                        $paynowdb->status = $info['status'];
                        $paynowdb->poll_url = $info['pollurl'];
                        $paynowdb->hash = $info['hash'];
                        $paynowdb->save();

                        $app = new Application();
                        $app->user_id = Auth::id();
                        $app->renewal_id = $renewal->id;
                        $app->status = 0;
                        $app->payment = true;
                        $app->save();

                        //transaction update
                        $trans = new Transaction();
                        $trans->user_id = Auth::id();
                        $trans->reference = $info['paynowreference'];
                        $trans->activity = "Application";
                        $trans->method = $wallet;
                        $trans->amount = $info['amount'];
                        $trans->status = 1;
                        $trans->save();

                        return redirect()->route('user-dashboard')->with('success', 'Succesfully paid your permit application');
                    }


                    $count++;
                    if ($count > $timeout) {
                        $info = $status->data();

                        $paynowdb = new Paynowlog();
                        $paynowdb->reference = $info['reference'];
                        $paynowdb->paynow_reference = $info['paynowreference'];
                        $paynowdb->amount = $info['amount'];
                        $paynowdb->status = $info['status'];
                        $paynowdb->poll_url = $info['pollurl'];
                        $paynowdb->hash = $info['hash'];
                        $paynowdb->save();


                        //transaction update
                        $trans = new Transaction();
                        $trans->user_id = Auth::id();
                        $trans->reference = $info['paynowreference'];
                        $trans->activity = "Application";
                        $trans->method = $wallet;
                        $trans->amount = $info['amount'];
                        $trans->status = 2;
                        $trans->save();

                        return redirect()->back()->with('error', 'Taking too long wait a moment and refresh');
                    } //endif
                } //endwhile
            } //endif


            return redirect()->back()->with('error', 'Cannot perform transaction at the moment');

        }catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function extend_index()
    {
        return view('user.extend');
    }

    public function extend(Request $request)
    {
        $request->validate([
            'renewal' => ['required', 'integer'],
            'email' => ['email', 'required'],
            'phone' => ['required', 'digits:10', 'starts_with:07']
        ]);

        try{
            $renewal = Renewal::find($request->renewal);

            $permit = Permit::where('user_id', Auth::id())->first();
            if(is_null($permit))
            {
                return redirect()->back()->with('error', 'You have no permit record found!');
            }

            $wallet = "ecocash";

            //get all data ready
            $email = $request->email;
            $phone = $request->phone;
            $amount = $renewal->price;

            /*determine type of wallet*/
            if (strpos($phone, '071') === 0) {
                $wallet = "onemoney";
            }

            $paynow = new \Paynow\Payments\Paynow(
                "11336",
                "1f4b3900-70ee-4e4c-9df9-4a44490833b6",
                route('user-apply'),
                route('user-apply'),
            );

            // Create Payments
            $invoice_name = "permit-extension-" . time();
            $payment = $paynow->createPayment($invoice_name, $email);

            $payment->add("Zimparks Permits", $amount);

            $response = $paynow->sendMobile($payment, $phone, $wallet);


            // Check transaction success
            if ($response->success()) {

                $timeout = 9;
                $count = 0;

                while (true) {
                    sleep(3);
                    // Get the status of the transaction
                    // Get transaction poll URL
                    $pollUrl = $response->pollUrl();
                    $status = $paynow->pollTransaction($pollUrl);


                    //Check if paid
                    if ($status->paid()) {
                        // Yay! Transaction was paid for
                        // You can update transaction status here
                        // Then route to a payment successful
                        $info = $status->data();

                        $paynowdb = new Paynowlog();
                        $paynowdb->reference = $info['reference'];
                        $paynowdb->paynow_reference = $info['paynowreference'];
                        $paynowdb->amount = $info['amount'];
                        $paynowdb->status = $info['status'];
                        $paynowdb->poll_url = $info['pollurl'];
                        $paynowdb->hash = $info['hash'];
                        $paynowdb->save();

                        $date = Carbon::now();
                        $date->addMonths($renewal->length);

                        $permit->expiry_date = $date;
                        $permit->save();

                        //transaction update
                        $trans = new Transaction();
                        $trans->user_id = Auth::id();
                        $trans->reference = $info['paynowreference'];
                        $trans->activity = "Extension";
                        $trans->method = $wallet;
                        $trans->amount = $info['amount'];
                        $trans->status = 1;
                        $trans->save();

                        return redirect()->back()->with('success', 'Succesfully paid your permit extension');
                    }


                    $count++;
                    if ($count > $timeout) {
                        $info = $status->data();

                        $paynowdb = new Paynowlog();
                        $paynowdb->reference = $info['reference'];
                        $paynowdb->paynow_reference = $info['paynowreference'];
                        $paynowdb->amount = $info['amount'];
                        $paynowdb->status = $info['status'];
                        $paynowdb->poll_url = $info['pollurl'];
                        $paynowdb->hash = $info['hash'];
                        $paynowdb->save();


                        //transaction update
                        $trans = new Transaction();
                        $trans->user_id = Auth::id();
                        $trans->reference = $info['paynowreference'];
                        $trans->activity = "Application";
                        $trans->method = $wallet;
                        $trans->amount = $info['amount'];
                        $trans->status = 2;
                        $trans->save();

                        return redirect()->back()->with('error', 'Taking too long wait a moment and refresh');
                    } //endif
                } //endwhile
            } //endif


            return redirect()->back()->with('error', 'Cannot perform transaction at the moment');

        }catch(Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
