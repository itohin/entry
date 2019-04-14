<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    public function activate(Request $request)
    {
        try {
            $user = User::byActivationColumns($request->email, $request->token)->firstOrFail();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withError('Sorry, link is broken');
        }

        $user->update([
            'active' => true,
            'activation_token' => null
        ]);

        Auth::loginUsingId($user->id);

        return redirect()->route('home')->withSuccess('Activated! You are now signed in.');
    }
}
