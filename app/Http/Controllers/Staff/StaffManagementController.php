<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffManagementController extends Controller
{
    public function index(){
        dd("Hello There");
    }

    public function Dashboard(){
        return view('admin.staff.dashboard');
    }

}
