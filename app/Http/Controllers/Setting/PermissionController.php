<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    private $categories = [];
    public function __construct()
    {
        date_default_timezone_set("Asia/Jakarta");
        $this->categories = [
            'Role',
            'Order',
            'User',
            'Menu',
            'Product'
        ];

        $this->middleware(['auth']);
        $this->middleware('permission:menu-role', ['only' => ['index', 'show', 'datatables']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        $categories = $this->categories;
        return view('endee.settings.permissions.index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->categories;
        return view('endee.settings.permissions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required', 'prefix' => 'required']);
        
        Permission::create([
            'name' => $request->prefix.'-'.strtolower($request->name)
        ]);

        return to_route('permissions.index')->with('success', 'Permission created.');
    }

    public function edit(Permission $permission)
    {
        $roles = Role::all();
        $categories = $this->categories;

        $prefix = explode('-', $permission->name);
        return view('endee.settings.permissions.edit', compact('permission', 'roles', 'categories', 'prefix'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate(['name' => 'required']);
        $permission->update([
            'name' => $request->prefix.'-'.strtolower($request->name)
        ]);

        return to_route('permissions.index')->with('success', 'Permission updated.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'Permission deleted.');
    }

    public function datatables(Request $request)
    {
        $items = Permission::latest()->get();

        $no = 1;
        $results['data'] = [];

        foreach ($items as $key => $value) :
            $checkbox = '<div class="form-check check-tables">
                <input class="form-check-input" type="checkbox" value="something">
            </div>';

            $url_edit = route('permissions.edit', $value->id);

            $actions = '<div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" 
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg> 
                            <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1" 
                        data-popper-placement="bottom-end" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-170px, 28px);">
                        <a class="dropdown-item d-flex align-items-center" href="'.$url_edit.'">
                            <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg> 
                            Edit 
                        </a>
                        <a data-permission="'.$value->id.'" class="delete-permission dropdown-item d-flex align-items-center" href="#">
                            <svg class="dropdown-icon text-danger me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> 
                            Delete
                        </a>
                    </div>
                </div>';

            $created_at = '-';
            if(!empty($value->created_at)) :
                $created_at = date('d M Y', strtotime($value->created_at)) .'<br>'. date('H:i:s', strtotime($value->created_at));
            endif;

            $results['data'][$key] = array(
                $checkbox,

                $no++,
                strtotime($value->created_at),
                $created_at,
                '<div class="d-flex align-items-center me-3 lh-130">
                    <span class="dot rounded-circle bg-tertiary me-2"></span> 
                    <span class="fw-normal small">'.strtoupper($value->name).'</span>
                </div>',
                '<span class="badge super-badge bg-success">'. $value->guard_name.'</span>',
                $actions
            );
        endforeach;

        return response()->json($results, 200);
    }
}
