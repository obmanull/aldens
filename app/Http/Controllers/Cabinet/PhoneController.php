<?php

namespace App\Http\Controllers\Cabinet;

use App\Services\Sms\SmsSender;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PhoneController extends Controller
{
    private $sms;
    /**
     * @return void
     */
    public function __construct(SmsSender $sms)
    {
        $this->sms = $sms;
        $this->middleware('auth');
    }

    public function request(Request $request)
    {
        $user = Auth::user();

        try {
            $token = $user->requestPhoneVerification(Carbon::now());
            $this->sms->send($user->phone, 'Phone verification token '. $token);
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
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
