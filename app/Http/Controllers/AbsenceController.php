<?php

namespace App\Http\Controllers;

use App\Enums\Hour;
use App\Models\Absence;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

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
            ->with('user.department')
            ->get();

        // Vista Semanal: usamos parámetros 'weekly_date' y 'weekly_hour'
        $selectedDate = $request->query('weekly_date', Carbon::now()->toDateString());
        $selectedHour = $request->query('weekly_hour', '1manana'); // Valor por defecto para la vista semanal
        $weeklyAbsences = Absence::where('date', $selectedDate)
            ->where('hour', $selectedHour)
            ->with('user')
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
        $timeSlots = Hour::cases();
        return view('absences.create', compact('timeSlots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'date' => 'required|date',
            'hour' => ['required', new Enum(Hour::class)],
            'comment' => 'nullable|string|max:255',
        ]);


        Absence::create([
            'user_id' => $data['user_id'],
            'date' => $data['date'],
            'hour' => $data['hour'],
            'comment' => $data['comment'] ?? null,
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

    public function all()
    {
        $absences = Absence::with('user')->orderBy('date', 'desc')->get();
        return view('absences.index', compact('absences'));
    }
}
