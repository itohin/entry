<?php

namespace App\Http\Controllers;

use App\Events\UserActivationEmail;
use App\User;
use Illuminate\Http\Request;

class ActivationResendController extends Controller
{
    public function showResendForm()
    {
        return view('auth.activate.resend');
    }

    public function resend(Request $request)
    {
        $this->validateResendRequest($request);

        $user = User::byEmail($request->email)->first();

        event(new UserActivationEmail($user));

        return redirect()->route('login')
            ->withSuccess('Activation email has been resent');
    }

    public function validateResendRequest(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Could not find that account.'
        ]);
    }
}
