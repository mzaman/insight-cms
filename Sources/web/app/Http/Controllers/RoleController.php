<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleController extends Controller
{
    public function __construct(private RoleRepositoryInterface $roleRepository)
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->roleRepository->all()->toArray());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required',
            'slug'=>'required',
            'permission_id'=>'required|array'
        ]);

        $role = $this->roleRepository->create($data);
        $this->roleRepository->permissions($role)->sync($data['permission_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->find($id);
        $role->permissions_id = $this->roleRepository->permissions($role)->get();
        return response()->json($role->toArray());
    }

}
