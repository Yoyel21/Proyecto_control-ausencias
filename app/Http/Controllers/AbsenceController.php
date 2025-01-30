<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date', Carbon::now()->toDateString());
        $hour = $request->query('hour', Carbon::now()->format('H:00'));

        $absences = Absence::where('date', $date)
            ->where('hour', $hour)
            ->with('user', 'department')
            ->get();

        return view('absences.index', compact('absences', 'date', 'hour'));
    }

    public function update(Request $request, Absence $absence)
    {
        if (!$absence->canEditOrDelete()) {
            return back()->with('error', 'No puedes editar una ausencia pasados 10 minutos.');
        }

        $absence->update($request->validated());
        return redirect()->route('admin.absences')->with('success', 'Ausencia actualizada.');
    }

    public function destroy(Absence $absence)
    {
        if (!$absence->canEditOrDelete()) {
            return back()->with('error', 'No puedes eliminar una ausencia pasados 10 minutos.');
        }

        $absence->delete();
        return redirect()->route('admin.absences')->with('success', 'Ausencia eliminada.');
    }

    public function create()
    {
        return view('absences.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'hour' => 'required',
            'comment' => 'nullable|string|max:255',
        ]);

        Absence::create([
            'user_id' => Auth::id(),
            'department_id' => Auth::user()->department_id,
            'date' => $request->date,
            'hour' => $request->hour,
            'comment' => $request->comment,
        ]);

        return redirect()->route('dashboard')->with('success', 'Ausencia registrada con éxito.');
    }
}
