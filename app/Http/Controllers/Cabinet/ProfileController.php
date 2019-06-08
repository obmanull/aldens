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
        return view('cabinet.profile', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        $user->update($request->all());

        return back()->with('status', 'Profile update successful');
    }
}
