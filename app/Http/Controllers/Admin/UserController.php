<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UserRequest;

use Spatie\Permission\Models\Role;

use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('user.index')) {
            return abort(401);
        }

        return view('admin.users.index');
    }
    
    public function create()
    {
        if (! Gate::allows('user.create')) {
            return abort(401);
        }

        $roles = \Spatie\Permission\Models\Role::select('id', 'name')
        ->orderBy('name', 'ASC')
        ->pluck('name','id');
 

        return view('admin.users.form', compact('roles'));
    }

    
    public function store(UserRequest $request)
    {

        if (! Gate::allows('user.create')) {
            return abort(401);
        }

        $get_year_old = new User;

        if($get_year_old->getAge($request->input('birth_date')) < 18)
        {
            $notification = array(
                'message'    => 'Debe ser mayor de edad',
                'alert_type' => 'warning',);
    
            \Session::flash('notification', $notification);

            return back()->withInput()->withErrors(['birth_date', 'Debe ser mayor de edad']);
        }

        $user = User::create($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : '';
        $user->assignRole($roles);

        $notification = array(
            'message'    => 'Actualizacion Exitosa!',
            'alert_type' => 'success',);

            \Session::flash('notification', $notification);

        return view('admin.users.index');

    }

    
    public function show($id)
    {
        if (! Gate::allows('user.show')) {
            return abort(401);
        }
        
        $user    = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    
    public function edit($id)
    {
        if (! Gate::allows('user.edit')) {
            return abort(401);
        }

        $data  = User::findOrFail($id);

        $roles = \Spatie\Permission\Models\Role::select('id', 'name')
        ->orderBy('name', 'ASC')
        ->pluck('name','id');

        return view('admin.users.form', compact('data','roles'));
    }

   
    public function update(UserRequest $request, $id)
    {
        if (! Gate::allows('user.edit')) {
            return abort(401);
        }

        $get_year_old = new User;

        if($get_year_old->getAge($request->input('birth_date')) < 18)
        {
            $notification = array(
                'message'    => 'Debe ser mayor de edad',
                'alert_type' => 'warning',);
    
            \Session::flash('notification', $notification);

            return back()->withInput()->withErrors(['birth_date', 'Debe ser mayor de edad']);
        }

        $user = User::findOrFail($id);

        $user->fill($request->except(['identification','email']))->save();

        $roles = $request->input('roles') ? $request->input('roles') : '';
        $user->syncRoles($roles);

        $notification = array(
            'message'    => 'Actualizacion Exitosa!',
            'alert_type' => 'success',);

        \Session::flash('notification', $notification);

        return view('admin.users.index');
    }


    public function destroy($id)
    {
        if (! Gate::allows('user.destroy')) {
            return abort(401);
        }

        $user = User::findOrFail($id);

        if ($user->name != 'Admin') {
           $user->delete();
        }
        
        return response(null, 204);
    }

    public function table(Request $request)
    {
        $query = User::query();

        return Datatables::of($query)->addColumn('action', function ($dat) {

            $btn_delete = '<button class="btn btn-sm btn-danger btn-delete" title="delete '.$dat->name.'" data-remote="'.route("admin.users.destroy", $dat->id).'"><i class="far fa-trash-alt"></i></button> ';
            if ($dat->name == 'Admin') {
                $btn_delete = '';
            }

            return ' <a href="'.route("admin.users.show", $dat->id).'" class="btn btn-sm btn-primary"><i class="fas fa-eye" title="Show: '.$dat->name.'"></i></a>
                <a href="'.route("admin.users.edit", $dat->id).'" class="btn btn-sm btn-secondary"><i class="far fa-edit" title="Edit: '.$dat->name.'"></i></a> '
                .$btn_delete;
        })
        ->addColumn('role', function ($user) {
            return  ucfirst($user->roles->first()->name);
        })
        ->addColumn('year_old', function ($user) {
            return  Carbon::parse($user->birth_date)->age;
        })
        ->editColumn('created_at', function ($users){
            return date('d-m-y', strtotime($users->created_at) );
        })
        ->filterColumn('created_at', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(users.created_at,'%m/%d/%y') like ?", ["%$keyword%"]);
        })
        ->editColumn('birth_date', function ($users){
            return date('d-m-y', strtotime($users->birth_date) );
        })
        ->filterColumn('birth_date', function ($query, $keyword) {
            $query->whereRaw("DATE_FORMAT(users.birth_date,'%m/%d/%y') like ?", ["%$keyword%"]);
        })
        ->rawColumns(['action','year_old','role'])
        ->make(true);
    }
}
