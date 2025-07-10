<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Activitylog\Facades\LogBatch;
use App\Helpers\ActivityLogHelper;

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
                
                // Log successful login
                ActivityLogHelper::logLogin(Auth::user());
                
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil Login'
                ]);
                return redirect('/dashboard');
            }else {
                // Log failed login attempt with credentials
                ActivityLogHelper::logFailedLogin($request->username, $request->password);
                
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
                
                // Log successful admin login
                ActivityLogHelper::logLogin(Auth::guard('admin')->user());
                
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil Login'
                ]);
                return redirect('/dashboard');
            }else {
                // Log failed admin login attempt with credentials
                ActivityLogHelper::logFailedLogin($request->username, $request->password);
                
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
        // Log logout activity before actually logging out
        if (Auth::check()) {
            ActivityLogHelper::logLogout(Auth::user());
        } elseif (Auth::guard('admin')->check()) {
            ActivityLogHelper::logLogout(Auth::guard('admin')->user());
        }
        
        Auth::logout();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
}
