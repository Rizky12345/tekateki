<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class authcontroller extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'user_id' => ['required', 'integer'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $id = Auth::id();
            $get = User::find($id);
            return redirect()->intended('home');
        }else{
            return back()->with('messege','user id dan password salah');
        }
    }
    public function logout(){
        AUTH::logout();
        return redirect('/login');
    }
    public function page(){
        if (!isset(Auth::user()->name)) {
            return view('login_form',[
                "title" => "Login_form"
            ]);
        }else{
            return redirect("user");
        }
    }
}