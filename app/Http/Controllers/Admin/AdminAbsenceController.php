<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\User;

class AdminAbsenceController extends Controller
{
    public function index()
    {
        // Obtener todas las ausencias con la información de usuario y departamento
        $absences = Absence::with('user', 'department')->orderBy('date', 'desc')->get();
        $users = User::all(); // Obtener todos los usuarios
        $timeSlots = ['Mañana', 'Tarde', 'Noche']; // Franja horaria (puedes personalizarla según tu sistema)

        return view('admin.absences.index', compact('absences', 'users', 'timeSlots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'hour' => 'required|string',
            'comment' => 'nullable|string|max:255',
        ]);

        // Crear la ausencia en nombre de otro usuario
        Absence::create([
            'user_id' => $data['user_id'],
            'department_id' => User::find($data['user_id'])->department_id, // Asociar el departamento
            'date' => $data['date'],
            'hour' => $data['hour'],
            'comment' => $data['comment'],
        ]);

        return redirect()->route('admin.absences.index')->with('success', 'Ausencia registrada correctamente.');
    }

    public function destroy(Absence $absence)
    {
        $absence->delete();
        return redirect()->route('admin.absences.index')->with('success', 'Ausencia eliminada correctamente.');
    }
}
