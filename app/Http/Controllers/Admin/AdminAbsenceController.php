<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\User;
use App\Enums\Hour;
use Illuminate\Validation\Rules\Enum;

class AdminAbsenceController extends Controller
{
    public function index()
    {
        // Obtener todas las ausencias con la información de usuario y departamento
        $absences = Absence::with('user')->orderBy('date', 'desc')->orderBy('hour')->get();
        $users = User::all(); // Obtener todos los usuarios
        $timeSlots = Hour::cases(); // Franja horaria 

        return view('admin.adminAbsences', compact('absences', 'users', 'timeSlots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'hour' => ['required', new Enum(Hour::class)],
            'comment' => 'nullable|string|max:255',
        ]);

        Absence::create([
            'user_id' => $data['user_id'],
            'department_id' => User::find($data['user_id'])->department_id, // Asociar el departamento
            'date' => $data['date'],
            'hour' => $data['hour'],
            'comment' => $data['comment'],
        ]);

        return redirect()->route('admin.absences.index')->with('success', 'Ausencia registrada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $absence = Absence::findOrFail($id);

        $data = $request->validate([
            'date' => 'required|date',
            'hour' => ['required', new Enum(Hour::class)],
            'comment' => 'nullable|string|max:255',
        ]);

        $absence->update($data);

        return redirect()->route('admin.absences.index')->with('success', 'Ausencia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->delete();

        return redirect()->route('admin.absences.index')->with('success', 'Ausencia eliminada correctamente.');
    }
}