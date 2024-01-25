<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set("Asia/Jakarta");
        $this->middleware(['auth']);
        $this->middleware('permission:menu-user', ['only' => ['index', 'datatables']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        $filter_user = User::role('visitor')->latest()->get();
        $roles = Role::pluck('name', 'name')->all();
        return view('endee.catalog.users.index', compact('filter_user', 'roles'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('endee.catalog.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|same:confirm-password',
            'roles'     => 'required',
            'address'   => 'required',
        ];

        $input = $request->all();
        $this->validate($request, $data);
        
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        #buat user berdasarkan role yg dipilih
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $userRole = $user->roles->pluck('name', 'name')->first();
        
        return view('endee.catalog.users.profile', compact('user', 'userRole'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->first();

        return view('endee.catalog.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {   
        $data = [
            'password'  => 'same:confirm-password',
            'roles'     => 'required',
            'address'   => 'required'
        ];

        $input = $request->all();
        $this->validate($request, $data);
        
        if(!empty($input['password'])) :
            $input['password'] = Hash::make($input['password']);
        else:
            $input = Arr::except($input, array('password'));    
        endif;
        
        $user = User::find($id);

        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success', 'User deleted successfully');
    }
    
    public function datatables(Request $request)
    {
        $role = $request->role;

        $q = User::select('*');
        
        if($role != 'All') :
            $q->role($role);
        endif;

        $items = $q->latest()->get();

        $no = 1;
        $results['data'] = [];

        foreach ($items as $key => $value) :
            $checkbox = '<div class="form-check font-size-16">
                <input class="form-check-input uid" value="' . $value->id . '" type="checkbox" id="uid_' . $value->id . '">
                <label class="form-check-label" for="uid_' . $value->id . '"></label>
            </div>';

            $url_detail = route('users.show', $value->id);
            $url_edit = route('users.edit', $value->id);
                    
            $actions = '<div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" 
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg> 
                            <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1" 
                        data-popper-placement="bottom-end" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-170px, 28px);">
                        <a class="dropdown-item d-flex align-items-center" href="'.$url_detail.'">
                            <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path><path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                            Detail
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="'.$url_edit.'">
                            <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg> 
                            Edit 
                        </a>
                        <a data-user="'.$value->id.'" class="delete-user dropdown-item d-flex align-items-center" href="#">
                            <svg class="dropdown-icon text-danger me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> 
                            Delete
                        </a>
                    </div>
                </div>';

            $role = '';
            if(!empty($value->getRoleNames())) :
                foreach($value->getRoleNames() as $v) :
                    $role .= '<span class="badge super-badge bg-warning">'.$v.'</span>';
                endforeach;
            endif;

            $created_at = '-';
            if(!empty($value->created_at)) :
                $created_at = date('d M Y', strtotime($value->created_at)) .'<br>'. date('H:i:s', strtotime($value->created_at));
            endif;

            $results['data'][$key] = array(
                $checkbox,

                $no++,
                strtotime($value->created_at),
                $created_at,
                $value->name,
                $value->email,
               

                $role,
                $value->address,
                $actions
            );
        endforeach;

        return response()->json($results, 200);
    }

    public function details(Request $request)
    {
        if($request->ajax()) :
            $id = $request->user;
            $user = User::where('id', $id)->first();
            $data = '';

            if($user) :
                $data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'address' => $user->address
                ];
            endif;

            return [
                'status' => true,
                'data'   => $data
            ];
        endif;
    }
}
