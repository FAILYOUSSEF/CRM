<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
 
class RoleController extends Controller {
    public function __construct() {
        $this->middleware('permission:role-list',   ['only' => ['index','show']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit',   ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    public function index() {
        $roles = Role::withCount('permissions')->paginate(15);
        return view('admin.roles.index', compact('roles'));
    }
    public function create() {
        $permissions = Permission::orderBy('name')->get()->groupBy(fn($p) => explode('-',$p->name)[0]);
        return view('admin.roles.create', compact('permissions'));
    }
    public function store(Request $request) {
        $request->validate(['name'=>'required|unique:roles,name','permission'=>'nullable|array']);
        $role = Role::create(['name'=>$request->name,'guard_name'=>'web']);
        $role->syncPermissions($request->permission ?? []);
        return redirect()->route('admin.roles.index')->with('success','Role created.');
    }
    public function show(Role $role) {
        $rolePermissions = $role->permissions;
        return view('admin.roles.show', compact('role','rolePermissions'));
    }
    public function edit(Role $role) {
        $permissions    = Permission::orderBy('name')->get()->groupBy(fn($p) => explode('-',$p->name)[0]);
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.roles.edit', compact('role','permissions','rolePermissions'));
    }
    public function update(Request $request, Role $role) {
        $request->validate(['name'=>'required|unique:roles,name,'.$role->id,'permission'=>'nullable|array']);
        $role->update(['name'=>$request->name]);
        $role->syncPermissions($request->permission ?? []);
        return redirect()->route('admin.roles.index')->with('success','Role updated.');
    }
    public function destroy(Role $role) {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success','Role deleted.');
    }
}