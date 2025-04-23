<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionController extends Controller
{
    public function __construct(private PermissionRepositoryInterface $permissionRepository)
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
        return response()->json($this->permissionRepository->all()->toArray());
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
        ]);

        $this->permissionRepository->create($data);
    }
}
