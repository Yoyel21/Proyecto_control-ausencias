<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserImportController extends Controller
{
    public function showUploadForm()
    {
        return view('admin.upload-users');
    }

    public function importUsers(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen($request->file('csv_file')->getPathname(), "r");

        while (($data = fgetcsv($file, 1000, ";")) !== FALSE) {
            $nombre = $data[0];
            $apellidos = $data[1];
            $email = $data[2];
            $dept = $data[3];
            $alias = $data[4];

            // Buscar el departamento o crearlo si no existe.
            $department = Department::firstOrCreate(['name' => $dept]);

            // Verificar si el usuario ya existe.
            if (!User::where('email', $email)->exists()) {
                User::create([
                    'name' => "$nombre $apellidos",
                    'email' => $email,
                    'department_id' => $department->id,
                    'alias' => $alias,
                    'password' => Hash::make('password'),
                ]);
            }
        }

        fclose($file);

        return redirect()->back()->with('success', 'Usuarios importados correctamente.');
    }
}
