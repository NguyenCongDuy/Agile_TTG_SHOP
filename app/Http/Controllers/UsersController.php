<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function roles()
    {
        return view('admin.users.roles');
    }

    public function store(Request $request)
    {
        // Logic to store user
    }
}
