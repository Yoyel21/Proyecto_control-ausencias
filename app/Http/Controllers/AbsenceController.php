<?php

namespace App\Http\Controllers;

use App\Enums\Hour;
use App\Models\Absence;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function index(Request $request)
    {
        // Vista Diaria: usamos parámetros 'daily_date' y 'daily_hour'
        $currentDate = $request->query('daily_date', Carbon::now()->toDateString());
        // Valor por defecto: '1mañana'
        $currentHour = $request->query('daily_hour', '1manana');

        $dailyAbsences = Absence::where('date', $currentDate)
            ->where('hour', $currentHour)
            ->with('user', 'department')
            ->get();

        // Vista Semanal: usamos parámetros 'weekly_date' y 'weekly_hour'
        $selectedDate = $request->query('weekly_date', Carbon::now()->toDateString());
        $selectedHour = $request->query('weekly_hour', '1mañana'); // Valor por defecto para la vista semanal
        $weeklyAbsences = Absence::where('date', $selectedDate)
            ->where('hour', $selectedHour)
            ->with('user', 'department')
            ->get();

        $timeSlots = Hour::cases();

        return view('absences.index', compact(
            'currentDate',
            'currentHour',
            'dailyAbsences',
            'selectedDate',
            'selectedHour',
            'weeklyAbsences',
            'timeSlots'
        ));
    }

    public function create()
    {
        return view('absences.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'hour' => 'required',
            'comment' => 'nullable|string|max:255',
        ]);

        Absence::create([
            'user_id' => Auth::id(),
            'department_id' => Auth::user()->department_id,
            'date' => $data['date'],
            'hour' => $data['hour'],
            'comment' => $data['comment'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Ausencia registrada con éxito.');
    }

    public function update(Request $request, Absence $absence)
    {
        if (!$absence->canEditOrDelete()) {
            return back()->with('error', 'No puedes editar una ausencia pasados 10 minutos.');
        }

        $data = $request->validate([
            'date' => 'required|date',
            'hour' => 'required',
            'comment' => 'nullable|string|max:255',
        ]);

        $absence->update($data);

        return redirect()->route('absences.index')->with('success', 'Ausencia actualizada.');
    }

    public function destroy(Absence $absence)
    {
        if (!$absence->canEditOrDelete()) {
            return back()->with('error', 'No puedes eliminar una ausencia pasados 10 minutos.');
        }

        $absence->delete();

        return redirect()->route('absences.index')->with('success', 'Ausencia eliminada.');
    }
}
