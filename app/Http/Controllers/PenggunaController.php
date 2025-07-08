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
     * @param  \App\Http\Requests\StorePenggunaRequest  $request
     * @return \Illuminate\Http\Response
     */
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

            $simpanuser->assignRole('user');
        
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
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            'role.required' => 'Role Akses Wajib diisi',
        ]);

        if ($validated->passes()) {

            $user = User::findOrFail($request->id_pengguna);
            $user->assignRole([$request->role]);

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
            'password' => 'required|min:6',
        ],[
            'username.required' => 'Username Wajib diisi',
            'password.required' => 'Password Wajib Diisi',
            'password.min' => 'Passowrd Minimal 6 Karakter'
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
                $update = User::where('id', $request->id)->update([
                    'username' => $request->username,
                    // 'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);   
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
                $deluser = User::where('id', $request->id)->delete();
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
            $deluser = User::where('id', $request->id)->delete();
            if ($deluser) {
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
