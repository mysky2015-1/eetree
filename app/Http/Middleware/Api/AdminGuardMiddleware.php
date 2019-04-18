<?php

namespace App\Http\Middleware\Api;

use App\Api\Helpers\ApiResponse;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminGuardMiddleware
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        config(['auth.defaults.guard' => 'admin']);

        if (!$this->shouldPassThrough($request)) {
            $user = Auth::user();
            if (!$user->allPermissions()->first(function ($permission) use ($this, $request) {
                return $this->shouldPassThrough($permission, $request);
            })) {
                return $this->failed('No permission', 403);
            }
        }
        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        $excepts = config('eetree.auth.excepts', [
            '/login',
            '/logout',
        ]);

        return collect($excepts)
            ->map(function ($item, $key) {
                return 'api/admin/' . trim($item, '/');
            })
            ->contains(function ($except) use ($request) {
                if ($except !== '/') {
                    $except = trim($except, '/');
                }

                return $request->is($except);
            });
    }
}
