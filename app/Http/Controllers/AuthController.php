<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\User;
use App\Models\Admin;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }

    public function admin()
    {
        return view('auth.loginadmin');
    }



    public function authentication(Request $request) {
        $validated = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
            // 'guard' => 'required'
        ],[
            'username.required' => 'Username Harus Diisi',
            'password.required' => 'Password harus Diisi',
            // 'guard.required' => 'Pilih Role Terlebih Dahulu'
        ]);

        if ($validated->passes()) { 
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                $request->session()->regenerate();
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil Login'
                ]);
                return redirect('/dashboard');
            }else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Login Gagal, Username / Password Salah'
                ]);
            }
            
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    public function authenticationAdmin(Request $request) {
        $validated = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required',
            // 'guard' => 'required'
        ],[
            'username.required' => 'Username Harus Diisi',
            'password.required' => 'Password harus Diisi',
            // 'guard.required' => 'Pilih Role Terlebih Dahulu'
        ]);

        if ($validated->passes()) { 
            if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
                $request->session()->regenerate();
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil Login'
                ]);
                return redirect('/dashboard');
            }else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Login Gagal, Username / Password Salah'
                ]);
            }
            
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
