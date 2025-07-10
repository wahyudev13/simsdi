<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Validator;

class RoleController extends Controller
{
    public function index(){
        $permission = Permission::get();
        return view('pages.master.master-role', compact('permission'));
    }

    public function data(){
        $get = Role::all();
        return DataTables::of($get)
        ->addIndexColumn()
        ->make(true);
    }

    public function store(Request $request){
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Disimpan'
        ]);
    }

    public function edit(Request $request){
        $role = Role::find($request->id);
        $permission_ids = $role->permissions->pluck('id');
        $role->permission_ids = $permission_ids;
        return response()->json($role);
    }

    public function update(Request $request){
        $role = Role::find($request->id);
        $role->name = $request->name;
        $role->save();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Diubah'
        ]);
    }

    public function delete(Request $request){
        $role = Role::find($request->id);
        $role->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Dihapus'
        ]);
    }

    public function addPermissionRole(Request $request) {
        $validated = Validator::make($request->all(),[
            'id' => 'required',
            // 'permis' => 'required', // Hapus validasi required pada permis
        ],[
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            // 'permis.required' => 'Permission Akses Wajib diisi',
        ]);

        if ($validated->passes()) {

            $role = Role::find($request->id);
            $role->syncPermissions($request->permis ? $request->permis : []);

            return response()->json([
                'status' => 200,
                'message' => 'Permission Akses Berhasil Disimpan',
            ]);
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    public function getPermission(Request $request) {
        $role = Role::find($request->id);
        $permision = Permission::whereIn('name', $role->getPermissionNames())->get();

        return DataTables::of($permision)
        ->make(true);
    }

    public function deletePermission(Request $request) {
        $role = Role::find($request->id);
        $delete_permis_role = $role->revokePermissionTo($request->permisname);

        if ($delete_permis_role) {
            return response()->json([
                'message' => 'Permission '.$request->permisname.' Berhasil Dihapus',
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
