<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        return view('admin.users');
    }

    // Método para registrar un usuario individualmente
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department_id' => 'required|exists:departments,id',
            'alias' => 'required|string|max:50|unique:users,alias',
        ]);

        // Crear el usuario sin contraseña (se gestionará con "Olvidé mi contraseña")
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'alias' => $request->alias,
            'password' => Hash::make('qwerty-1234'), // Contraseña temporal
        ]);

        return redirect()->route('admin.users')->with('success', 'Usuario registrado correctamente.');
    }

    // Método para procesar un archivo CSV y registrar usuarios en lote
    public function processCsv(Request $request)
    {
        // Validación del archivo
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        // Leer el archivo
        $file = fopen($request->file('csv_file')->getPathname(), 'r');
        $errores = [];

        while (($line = fgetcsv($file, 1000, ';')) !== FALSE) {
            if (count($line) !== 5) {
                $errores[] = "Formato incorrecto en la línea: " . implode(';', $line);
                continue;
            }

            [$name, $surname, $email, $dept, $alias] = $line;
            $department = Department::where('name', $dept)->first();

            if (!$department) {
                $errores[] = "Departamento '$dept' no encontrado para usuario $name $surname.";
                continue;
            }

            // Validar si el usuario ya existe
            if (User::where('email', $email)->exists()) {
                $errores[] = "El usuario con email '$email' ya está registrado.";
                continue;
            }

            // Crear el usuario
            User::create([
                'name' => $name . ' ' . $surname,
                'email' => $email,
                'department_id' => $department->id,
                'alias' => $alias,
                'password' => Hash::make('temporal123'), // Contraseña temporal
            ]);
        }

        fclose($file);

        if (!empty($errores)) {
            return redirect()->route('admin.users')->withErrors($errores);
        }

        return redirect()->route('admin.users')->with('success', 'Usuarios importados correctamente.');
    }
}
