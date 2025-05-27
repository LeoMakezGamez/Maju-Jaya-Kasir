<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.auth');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email'=>'required|email',
            'password'=>'required' 
        ]);

        if(Auth::attempt($attributes))
        {
            if (Auth::attempt($attributes)) {
                session()->regenerate();
                // return redirect('sales')->with('success', 'You are logged in successfully!');
                return redirect()->route('sales.index')
                ->with([
                    'msg' => 'You are logged in successfully!',
                    'type' => 'success',
                    'icon' => 'fa fa-check-circle',
                ]);
            }
            
        }
        else{

            return back()->withErrors(['email'=>'Email or password invalid.']);
        }
        
    }

    
    
    public function destroy()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'You\'ve been logged out.']);
    }
}
