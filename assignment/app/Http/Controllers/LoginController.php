<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('app.login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('admin/dashboard')->with('message', 'Signed in!');
        }
   
        return redirect('/')->with('message', 'Login details are not valid!');
    }

    public function signup()
    {
        return view('app.login.register');
    }
    
    public function adminsignup()
    {
        return view('app.login.adminregister');
    }

    public function signupsave(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',

        ]);
            
        $data = $request->all();
        $check = $this->create($data);
          
        return redirect("");
    }

    public function adminsignupsave(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',

        ]);
            
        $data = $request->all();
        $check = $this->createadmin($data);
          
        return redirect("/admin/dashboard");
    }
 
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role'=>'0',
      ]);
    } 

    public function createadmin(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role'=>'1',
      ]);
    } 


    public function dashboard()
    {
        return view('app.admin.dashboard');
    }

    public function userdashboard()
    {
        return view('app.user.userdashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }

}
