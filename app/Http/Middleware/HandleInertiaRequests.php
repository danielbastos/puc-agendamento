<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Illuminate\Support\Facades\Gate;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    private function menuPerms($user) {
        $res = [];
        if (Gate::check('user_gate', 'menu:dashboard')) $res[] =  [ 'key' => 'dashboard', 'title' => 'Dashboard', 'activeKey' => 'dashboard'];
        if (Gate::check('user_gate', 'menu:user.index')) $res[] = ['key' => 'user.index', 'title' => 'Usuários', 'activeKey' => 'user.*'];
        if (Gate::check('user_gate', 'menu:availability.index')) $res[] = ['key' => 'availability.index', 'title' => 'Disponibilidade', 'activeKey' => 'availability.*'];
        //if (Gate::allows($user, 'scheduling.index')) $res['menu:scheduling.index'] = ['title' => 'Agendamento', 'activeKey' => 'scheduling.*'];
        return $res;
    }

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'menu' => $this->menuPerms($request->user())
        ];
    }
}
