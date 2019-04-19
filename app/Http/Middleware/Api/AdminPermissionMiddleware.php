<?php

namespace App\Http\Middleware\Api;

use App\Api\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPermissionMiddleware
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
        if (!$this->ignorePassThrough($request)) {
            $user = Auth::user();
            if (!$user->allPermissions()->first(function ($permission) use ($request) {
                return $this->shouldPassThrough($permission, $request);
            })) {
                return $this->failed($user->allPermissions(), 403); //TODO
                return $this->failed('No permission', 403);
            }
        }
        return $next($request);
    }

    /**
     * If request should pass through the current permission.
     *
     * @param $permission
     * @param Request $request
     *
     * @return bool
     */
    public function shouldPassThrough(array $permission, Request $request)
    {
        if (empty($permission['http_method']) && empty($permission['http_path'])) {
            return true;
        }

        $method = $permission['http_method'];

        $matches = array_map(function ($path) use ($method) {
            $path = 'api/admin/' . trim($path, '/');

            if (\Illuminate\Support\Str::contains($path, ':')) {
                list($method, $path) = explode(':', $path);
                $method = explode(',', $method);
            }

            return compact('method', 'path');
        }, explode("\n", $permission['http_path']));

        foreach ($matches as $match) {
            if ($this->matchRequest($match, $request)) {
                return true;
            }
        }

        return false;
    }

    /**
     * If a request match the specific HTTP method and path.
     *
     * @param array   $match
     * @param Request $request
     *
     * @return bool
     */
    protected function matchRequest(array $match, Request $request)
    {
        if (!$request->is(trim($match['path'], '/'))) {
            return false;
        }

        $method = collect($match['method'])->filter()->map(function ($method) {
            return strtoupper($method);
        });

        return $method->isEmpty() || $method->contains($request->method());
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function ignorePassThrough($request)
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
