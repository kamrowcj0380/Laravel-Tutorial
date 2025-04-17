<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginName' => 'required',
            'loginPassword' => 'required'
        ]);

        if (auth()->attempt(['name' => $incomingFields['loginName'], 'password' => $incomingFields['loginPassword']])) {
            $request->session()->regenerate();
        }

        //Regardless, go back to homepage.
        return redirect("/");
    }

    public function logout() {
        auth()->logout();
        return redirect("/");
    }

    public function register(Request $request) {
        //Using "validate" and "=> required" means that Laravel handles missing values. If they aren't there, it won't proceed past this line.
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:25', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:200']
        ]);

        //Hash the user's password
        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user = User::create($incomingFields);

        auth()->login($user);
        return redirect('/');
    }
}
