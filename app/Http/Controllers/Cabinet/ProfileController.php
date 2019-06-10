<?php

namespace App\Http\Controllers\Cabinet;

use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('cabinet.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('cabinet.profile.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|regex:/^\d+$/s'
        ]);

        $oldPhone = $user->phone;

        $user->update($request->all());

        if($oldPhone !== $user->phone) {
            $user->unverifyPhone();
        }

        return redirect()->route('cabinet.profile.index')->with('status', 'Profile update successful');
    }
}
