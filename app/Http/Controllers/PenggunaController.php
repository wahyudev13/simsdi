<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\ActivityLogHelper;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $database_1 =  env('DB_DATABASE');
        $pegawai = Pegawai::whereNotIn('pegawai.stts_aktif',['keluar'])->join('departemen','pegawai.departemen','=','departemen.dep_id')
        ->select('pegawai.id','pegawai.nik','pegawai.nama','pegawai.jk','pegawai.jbtn','departemen.nama AS nama_dep')
        ->get();

        $role = Role::get();

        $data = [
            'pegawai' => $pegawai,
            'role' => $role,
        ];
        return view('pages.Master.master-pengguna', $data);
    }
    
    public function getuser() {
        $database_2 = config('database.connections.mysql2.database');
        $data_getuser = User::join("$database_2.pegawai as tbsik_pegawai",'pengguna.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->select('pengguna.id','pengguna.id_pegawai','tbsik_pegawai.nik as nik_pegawai','pengguna.username','tbsik_pegawai.nama','tbsik_pegawai.jbtn')
        ->orderBy('pengguna.created_at','desc')
        ->get();
      
        return DataTables::of($data_getuser)
        ->addIndexColumn()
        ->make(true);
    }
    
    public function load_pengguna(Request $request) {
        $pegawai = Pegawai::where('id', $request->id)->first();

        return response()->json([
            'data'=>$pegawai
        ]);
    }
    

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required|unique:pengguna',
            'username' => 'required|unique:pengguna',
            //'role' => 'required',
            'password' => 'required|min:6',
        ],[
            'id_pegawai.required' => 'Pilih Pegawai Terlebih Dahulu',
            'id_pegawai.unique' => 'ID Pegawai Sudah Digunakan',
            // 'role.required' => 'Role Akses Wajib diisi',
            'username.required' => 'Username Wajib diisi',
            'username.unique' => 'Username Sudah Digunakan',
            'password.required' => 'Password Wajib diisi',
            'password.min' => 'Passowrd Minimal 6 Karakter'
        ]);
      
        if ($validated->passes()) {
            $simpanuser = User::create([
                'id_pegawai' => $request->id_pegawai,
                'username' => $request->username,
                // 'email' => $request->email,
                'password' => Hash::make($request->password)
    
            ]);
            
            // Log activity
            ActivityLogHelper::logCrud('created', $simpanuser, 'Created new user: ' . $simpanuser->username);
        
            return response()->json([
                'status' => 200,
                'message' => 'Pengguna Berhasil Ditambah',
            ]);
        
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
        

        
    }

    public function settingRole(Request $request) {
        //$pegawai = User::where('id',$request->id)->first();
        $pegawai = User::findOrFail($request->id);
        $role = Role::whereIn('name', $pegawai->getRoleNames())->get();

        return DataTables::of($role)
        ->addIndexColumn()
        ->make(true);
    }


    public function show(Request $request) {
        $database_2 = config('database.connections.mysql2.database');

        $showpengguna = User::where('pengguna.id', $request->id)
        ->join("$database_2.pegawai as tbsik_pegawai",'pengguna.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->select('pengguna.id','pengguna.id_pegawai','pengguna.username',
        'tbsik_pegawai.nama','tbsik_pegawai.jbtn')
        ->first();

        if ($showpengguna) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $showpengguna
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function addRoleUser(Request $request) {
        $validated = Validator::make($request->all(),[
            'id_pengguna' => 'required',
            'role' => 'required',
        ],[
            'id_pengguna.required' => 'ID Pengguna Wajib diisi',
            'role.required' => 'Role Akses Wajib diisi',
        ]);

        if ($validated->passes()) {

            $user = User::findOrFail($request->id_pengguna);
            
            // Handle both single role and array of roles
            if (is_array($request->role)) {
                $user->assignRole($request->role);
                $roles = implode(', ', $request->role);
            } else {
                $user->assignRole([$request->role]);
                $roles = $request->role;
            }
            
            // Log activity
            ActivityLogHelper::log('Assigned roles to user: ' . $user->username, [
                'target_user_id' => $user->id,
                'target_user_username' => $user->username,
                'assigned_roles' => $roles,
                'action_performed_by' => Auth::user() ? Auth::user()->username : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->username : 'System'),
                'action_performed_by_id' => Auth::user() ? Auth::user()->id : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->id : null),
                'action_performed_by_type' => Auth::user() ? 'user' : (Auth::guard('admin')->user() ? 'admin' : 'system')
            ], 'user');

            return response()->json([
                'status' => 200,
                'message' => 'Role Akses Berhasil Ditambahkan',
            ]);
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    public function deleteRoleUser(Request $request) {
        $user = User::findOrFail($request->id);
        $delete_role_user = $user->removeRole($request->rolename);

        if ($delete_role_user) {
            // Log activity
            ActivityLogHelper::log('Removed role from user: ' . $user->username, [
                'target_user_id' => $user->id,
                'target_user_username' => $user->username,
                'removed_role' => $request->rolename,
                'action_performed_by' => Auth::user() ? Auth::user()->username : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->username : 'System'),
                'action_performed_by_id' => Auth::user() ? Auth::user()->id : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->id : null),
                'action_performed_by_type' => Auth::user() ? 'user' : (Auth::guard('admin')->user() ? 'admin' : 'system')
            ], 'admin');
            
            return response()->json([
                'message' => 'Role '.$request->rolename.' Berhasil Dihapus',
                'status' => 200,
            ]);
        }else {
            return response()->json([
                'error' => 'Gagal Hapus data',
                'status' => 500,
            ]);
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenggunaRequest  $request
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'nullable|min:6',
        ],[
            'username.required' => 'Username Wajib diisi',
            'password.min' => 'Password Minimal 6 Karakter'
        ]);
      
        if ($validated->passes()) {

            $username = User::where('username',$request->username)->whereNotIn('id',[$request->id])->get();
            $countuser = $username->count();
            if ($countuser > 0) {
                return response()->json([
                    'status' => 401,
                    'error' => 'Username '.$request->username.' Sudah Digunakan'
                ]);
            }else {
                $updateData = [
                    'username' => $request->username,
                ];
                
                // Only update password if provided
                if (!empty($request->password)) {
                    $updateData['password'] = Hash::make($request->password);
                }
                
                $user = User::findOrFail($request->id);
                $oldUsername = $user->username;
                
                $user->update($updateData);
                
                // Log activity
                ActivityLogHelper::logCrud('updated', $user, 'Updated user: ' . $oldUsername . ' to ' . $user->username);
                
                return response()->json([
                    'status' => 200,
                    'message' => 'Pengguna '.$request->pengguna.' Berhasil Diubah',
                ]);
            }
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
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $user = User::findOrFail($request->id);
        $role = $user->getRoleNames();
        $coun = $role->count();

        $permis = $user->getPermissionNames();
        
        $countper = $permis->count();

        // dd($coun);
        if ($coun > 0 || $countper > 0) {
            $delete_role_user = $user->roles()->detach();
            $delete_permis_user = $user->syncPermissions([]);
            if ($delete_role_user || $delete_permis_user) {
                $username = $user->username;
                $deluser = User::where('id', $request->id)->delete();
                
                // Log activity
                ActivityLogHelper::log('Deleted user: ' . $username, [
                    'target_user_id' => $request->id,
                    'target_user_username' => $username,
                    'had_roles' => $coun > 0,
                    'had_permissions' => $countper > 0,
                    'action_performed_by' => Auth::user() ? Auth::user()->username : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->username : 'System'),
                    'action_performed_by_id' => Auth::user() ? Auth::user()->id : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->id : null),
                    'action_performed_by_type' => Auth::user() ? 'user' : (Auth::guard('admin')->user() ? 'admin' : 'system')
                ], 'user');
                
                return response()->json([
                    'message' => 'Data '.$request->namapeg.' Berhasil Dihapus',
                    'status' => 200,
                ]);
            }else {
                return response()->json([
                    'error' => 'Gagal Hapus data',
                    'status' => 500,
                ]);
            }
        }else {
            $username = $user->username;
            $deluser = User::where('id', $request->id)->delete();
            if ($deluser) {
                // Log activity
                ActivityLogHelper::log('Deleted user: ' . $username, [
                    'target_user_id' => $request->id,
                    'target_user_username' => $username,
                    'had_roles' => false,
                    'had_permissions' => false,
                    'action_performed_by' => Auth::user() ? Auth::user()->username : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->username : 'System'),
                    'action_performed_by_id' => Auth::user() ? Auth::user()->id : (Auth::guard('admin')->user() ? Auth::guard('admin')->user()->id : null),
                    'action_performed_by_type' => Auth::user() ? 'user' : (Auth::guard('admin')->user() ? 'admin' : 'system')
                ], 'user');
                
                return response()->json([
                    'message' => 'Data '.$request->namapeg.' Berhasil Dihapus',
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
