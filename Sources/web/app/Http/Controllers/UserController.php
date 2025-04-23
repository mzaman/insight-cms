<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository)
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
        return response()->json($this->userRepository->all()->toArray());
    }

}
