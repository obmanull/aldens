<?php

namespace App\Http\Controllers\Cabinet;

use App\Entities\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PhoneController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function request(Request $request)
    {
        $user = Auth::user();

        try {
            $token = $user->requestPhoneVerification(Carbon::now());
        } catch (\Throwable $e) {
            return $request->session()->flash('error', $e->getMessage());
        }

        return redirect()->route('cabinet.phone.verify.form');
    }

    public function form()
    {
        return view('cabinet.profile.phone_verify_form');
    }

    public function verify(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, ['token' => 'required|string|max:255']);

        try {
            $user->verifyPhone(Carbon::now(),  $request->token);
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.profile.index')->with('success', 'Phone verified');
    }
}
