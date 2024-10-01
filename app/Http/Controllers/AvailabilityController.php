<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\StoreAssociateScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\User;


class AvailabilityController extends Controller
{
    const HORARIOS = [
        '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00',
        '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00'
    ];

    private function find($date = null, $doctor_id = null, $patient_id = null) {
        $query = Schedule::query();

        if (empty($date)) $query->where('a_date', '=', (new \DateTime())->format('Y-m-d'));
        else $query->orWhere('a_date', '=', \DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d'));

        if (!empty($doctor_id)) $query->where('doctor_id', '=', $doctor_id);
        if (!empty($patient_id)) $query->where('patient_id', '=', $patient_id);

        $models = $query->orderBy('a_date', 'ASC')->orderBy('time_start', 'ASC')->get();
        $data = [];
        foreach ($models as $model) {
            $el = $model->toArray();
            $el['doctor'] = $model->doctor;
            $el['patient'] = $model->patient;
            $el['a_date'] = \DateTime::createFromFormat('Y-m-d', $model->a_date)->format('d/m/Y');
            $el['past'] = $model->a_date.' '.$model->time_start <= \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $data[] = $el;
        }

        return $data;
        /*
        if (!empty($term)) {
            $query->orWhere('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%");
        }

        $models = $query->orderBy('updated_at', 'DESC')->get();

        $data = [];
        foreach ($models as $el) {
            $data[] = [
                'roles' => $el->roles->toArray(),
                ... $el->toArray(),
            ];
        }
        return $data;
        */
    }

    private function getDoctors() {
        return User::query()
            ->select('users.*')
            ->leftJoin('users_roles', 'users.id', '=', 'users_roles.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'users_roles.role_id')
            ->where('roles.gate_name', 'doctor')
            ->get();
    }


    private function getPatients() {
        return User::query()
            ->select('users.*')
            ->leftJoin('users_roles', 'users.id', '=', 'users_roles.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'users_roles.role_id')
            ->where('roles.gate_name', 'patient')
            ->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $doctor_id = request()->query('doctor_id');
        if ($request->user()->hasGate('doctor')) $doctor_id = $request->user()->id;
        return Inertia::render('Availability/Index', [
            'models' => $this->find(request()->query('date'), $doctor_id),
            'isDoctor' => $request->user()->hasGate('doctor'),
            'doctors' => $this->getDoctors(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $model = [];

        if ($request->user()->hasGate('doctor')) $model['doctor_id'] = $request->user()->id;

        return Inertia::render('Availability/Form', [
            'model' => $model,
            'horarios' => self::HORARIOS,
            'doctors' => $this->getDoctors(),
            'title' => 'Novos horários de disponibilidade',
            'breadcrumbs' => [
                ['title' => 'Disponibilidade', 'url' => route('availability.index')],
                ['title' => 'Novos horários'],
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        $data = $request->validated();
        foreach ($data['horarios'] as $horario) {
            $dt = \DateTime::createFromFormat('d/m/Y', $horario['a_date'])->format('Y-m-d');
            
            if (Schedule::where([
                'doctor_id' => $data['doctor_id'],
                'a_date' => $dt,
                'time_start' => $horario['time_start'],
            ])->first()) continue;
            $model = new Schedule();
            $horario['doctor_id'] = $data['doctor_id'];
            $horario['a_date'] = $dt;
            $model->fill($horario);
            $res = $model->save();
        }
        return Redirect::route('availability.index');
    }

    /**
     * Display associated form 
     */
    public function schedule($id)
    {
        $model = Schedule::with(['patient', 'doctor'])->find($id);
        $modelView = $model->toArray();
        $modelView['a_date'] = \DateTime::createFromFormat('Y-m-d', $model->a_date)->format('d/m/Y');
        return Inertia::render('Availability/ScheduleForm', [
            'model' => $modelView,
            'patients' => $this->getPatients(),
            'title' => 'Associação de paciente',
            'breadcrumbs' => [
                ['title' => 'Disponibilidade', 'url' => route('availability.index')],
                ['title' => $model->doctor->name, 'url' => route('availability.index')],
                ['title' => 'Agendamento de horário'],
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function scheduleStore(StoreAssociateScheduleRequest $request)
    {
        $data = $request->validated();
        $model = Schedule::find($data['id']);
        $model->patient_id = $data['patient_id'];
        $model->save();
        return Redirect::route('availability.index', [
            'date'=> \DateTime::createFromFormat('Y-m-d', $model->a_date)->format('d/m/Y'),
            'doctor_id' => $model->doctor_id,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function scheduleCancel($id)
    {
        $model = Schedule::where('id', $id)
            ->where(DB::raw('TIMESTAMP(a_date, time_start)'), '>=', \Carbon\Carbon::now()->format('Y-m-d H:i:s'))
            ->first();
        if (!empty($model)) {
            $model->patient_id = null;
            $model->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        /*
        $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        //(new \DateTime())->format('Y-m-d H:i:s');
        $sql = Schedule::where('id', $id)
        ->where('patient_id', null)
        ->where(DB::raw('TIMESTAMP(a_date, time_start)'), '>=', $now)->toSQL();
        echo $sql;
        */

        Schedule::where('id', $id)
            ->where('patient_id', null)
            ->where(DB::raw('TIMESTAMP(a_date, time_start)'), '>=', \Carbon\Carbon::now()->format('Y-m-d H:i:s'))
            ->delete();

    }
}
