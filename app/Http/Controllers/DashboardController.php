<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    private function getSchedules() {
        $data = \DB::select('
            select
                s.id,
                s.a_date,
                s.time_start,
                s.time_end,
                s.doctor_id,
                s.patient_id,
                doc.name doctor_name,
                pat.name patient_name,
                TIMESTAMP(s.a_date, s.time_start) dt
            from schedules s
                inner join users doc on doc.id = s.doctor_id
                inner join users pat on pat.id = s.patient_id
            where
                s.patient_id = :patient_id
                or s.doctor_id = :doctor_id
            order by dt
        ', ['patient_id' => Auth::user()->id, 'doctor_id' => Auth::user()->id]);

        $dt = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $res = [];
        foreach ($data as $i=>$rec) {
            $el = $data[$i];

            $el->historical = $rec->dt < $dt;
            $el->a_date     = \DateTime::createFromFormat('Y-m-d', $rec->a_date)->format('d/m/Y');
            $el->dt         = \DateTime::createFromFormat('Y-m-d H:i:s', $rec->dt)->format('d/m/Y H:i:s');
            $el->time_start = substr($data[$i]->time_start, 0, 5);
            $el->time_end   = substr($data[$i]->time_end, 0, 5);
            if (Auth::user()->hasGate('doctor')) $el->name = $el->patient_name;
            else if (Auth::user()->hasGate('patient')) $el->name = $el->doctor_name;

            $res[$el->a_date][] = $el;
        }

        return $res;
    }

    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasGate('doctor') && !Auth::user()->hasGate('patient'))
            return Redirect::route('availability.index');

        return Inertia::render('Dashboard', [
            'schedules' => $this->getSchedules(),
        ]);
    }
}
