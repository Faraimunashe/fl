<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'natid' => ['required', 'max:20'],
            'sex' => ['required', 'max:6'],
            'phone' => ['required', 'digits:10', 'starts_with:07'],
            'address' =>['required', 'string'],
            'role' =>['required', 'string']
        ]);

        $user = User::create([
            'name' => $request->lastname.' '.$request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->addRole($request->role);

        event(new Registered($user));

        $acc = new Account();
        $acc->user_id = $user->id;
        $acc->fname = $request->firstname;
        $acc->lname = $request->lastname;
        $acc->natid = $request->natid;
        $acc->sex = $request->sex;
        $acc->phone = $request->phone;
        $acc->address = $request->address;
        $acc->save();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
