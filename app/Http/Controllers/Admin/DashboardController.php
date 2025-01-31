<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absence;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsuarios' => User::count(),
            'totalAusencias' => Absence::count(),
            'totalDepartamentos' => Department::count(),
        ]);
    }
}
