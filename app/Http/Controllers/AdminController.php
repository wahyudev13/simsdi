<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Pegawai;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.Setting.admin');
    }

    public function get() {

        $getadmin = Admin::get();
        return DataTables::of($getadmin)
        ->addIndexColumn()
        ->make(true);
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
        // Check if admin already exists
        $existingAdmin = Admin::count();
        if ($existingAdmin > 0) {
            return response()->json([
                'status' => 400,
                'error' => ['admin_limit' => 'Hanya dapat menyimpan 1 administrator saja']
            ]);
        }

        $validated = Validator::make($request->all(),[
            'username' => 'required|unique:admin',
            'password' => 'required'
        ],[
            'username.required' => 'Username Wajib diisi',
            'username.unique' => 'Username Sudah Digunakan',
            'password.required' => 'Password Wajib diisi',
        ]);

        if ($validated->passes()) {
            $admin = Admin::create([
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);

            // $user = Admin::findOrFail($request->id_pengguna);
            $admin->assignRole('superadmin');

            // Log activity
            ActivityLogHelper::logCrud('created', $admin, 'Created new administrator: ' . $admin->username);

            return response()->json([
                'status' => 200,
                'message' => 'Data Administrator Berhasil Disimpan'
            ]);
            
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $showadmin = Admin::where('id', $request->id)->first();
        if ($showadmin) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $showadmin
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'Username Wajib diisi',
            'password.required' => 'Password Wajib diisi'
        ]);

        if ($validated->passes()) {
            $admin = Admin::findOrFail($request->id);
            $oldUsername = $admin->username;
            
            $admin->update([
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);

            // Log activity
            ActivityLogHelper::logCrud('updated', $admin, 'Updated administrator: ' . $oldUsername . ' to ' . $admin->username);

            return response()->json([
                'status' => 200,
                'message' => 'Data Administrator Berhasil Diubah'
            ]);
            
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Check if this is the last admin
        $adminCount = Admin::count();
        if ($adminCount <= 1) {
            return response()->json([
                'status' => 400,
                'error' => ['admin_protection' => 'Tidak dapat menghapus admin terakhir. Minimal harus ada 1 administrator dalam sistem.']
            ]);
        }

        $admin = Admin::findOrFail($request->id);
        $role = $admin->getRoleNames();
        $coun = $role->count();

        // dd($coun);
        if ($coun > 0) {
            $delete_role_admin = $admin->roles()->detach();
            if ($delete_role_admin) {
                $username = $admin->username;
                $deladmin = Admin::where('id', $request->id)->delete();
                
                // Log activity
                ActivityLogHelper::log('Deleted administrator: ' . $username, [
                    'target_admin_id' => $request->id,
                    'target_admin_username' => $username,
                    'action_performed_by' => Auth::user() ? Auth::user()->username : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->username : 'System'),
                    'action_performed_by_id' => Auth::user() ? Auth::user()->id : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->id : null),
                    'action_performed_by_type' => Auth::user() ? 'user' : (Auth::guard('admin')->user() ? 'admin' : 'system')
                ], 'admin');
                
                return response()->json([
                    'message' => 'Data Berhasil Dihapus',
                    'status' => 200,
                ]);
            }else {
                return response()->json([
                    'error' => 'Gagal Hapus data',
                    'status' => 500,
                ]);
            }
        
            $username = $admin->username;
            $deladmin = Admin::where('id', $request->id)->delete();
            if ($deladmin) {
                // Log activity
                ActivityLogHelper::log('Deleted administrator: ' . $username, [
                    'target_admin_id' => $request->id,
                    'target_admin_username' => $username,
                    'action_performed_by' => Auth::user() ? Auth::user()->username : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->username : 'System'),
                    'action_performed_by_id' => Auth::user() ? Auth::user()->id : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->id : null),
                    'action_performed_by_type' => Auth::user() ? 'user' : (Auth::guard('admin')->user() ? 'admin' : 'system')
                ], 'admin');
                
                return response()->json([
                    'message' => 'Data Berhasil Dihapus',
                    'status' => 200,
                ]);
            }else {
                return response()->json([
                    'error' => 'Gagal Hapus data',
                    'status' => 500,
                ]);
            }
          
        }
    }
}
