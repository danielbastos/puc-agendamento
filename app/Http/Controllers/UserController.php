<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Models\Role;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function find($term = '') {
        $query = User::query();

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
    }

    private function getAddLinks() {
        $roles = Role::all();
        $res = [];
        foreach($roles as $role) {
            $res[] = [
                'url' => route('user.create', $role->gate_name),
                'title' => $role->name,
            ];
        }
        return $res;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Index', [
            'models' => $this->find(request()->query('term')),
            'addOptions' => $this->getAddLinks(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $model = new User();
        $viewModel = $model->toArray();
        return Inertia::render('User/Form', [
            'model' => $viewModel,
            'title' => 'Novo usuário',
            'breadcrumbs' => [
                ['title' => 'Usuários', 'url' => route('user.index')],
                ['title' => 'Novo'],
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, $role)
    {
        $data = $request->validated();
        Hash::make($data['password']);

        $model = new User();
        $model->fill($data);
        if ($model->isDirty('email')) {
            $model->email_verified_at = null;
        }
        $model->save();

        \App\Models\UserRole::factory()->create([
            'user_id' => $model->id,
            'role_id' => \App\Models\Role::where('gate_name', $role)->first()->id,
        ]);

        return Redirect::route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $model = User::where('id', $id)->firstOrFail();
        $viewModel = $model->toArray();
        return Inertia::render('User/Form', [
            'model' => $viewModel,
            'title' => "modificando usuário: {$model->name}",
            'breadcrumbs' => [
                ['title' => 'Usuários', 'url' => route('user.index')],
                ['title' => $model->name],
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $data = $request->validated();
        if (empty($data['password'])) unset($data['password']);
        else Hash::make($data['password']);

        $model = User::where('id', $id)->firstOrFail();
        $model->fill($data);
        if ($model->isDirty('email')) {
            $model->email_verified_at = null;
        }
        $model->save();

        return Redirect::route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        User::where('id', $id)->delete();
    }
}
