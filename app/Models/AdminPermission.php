<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $fillable = [
        'name', 'http_method', 'http_path',
    ];

    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\AdminRole', 'admin_role_permission', 'permission_id', 'role_id');
    }
    /**
     * If request should pass through the current permission.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function shouldPassThrough(Request $request)
    {
        if (empty($this->http_method) && empty($this->http_path)) {
            return true;
        }

        $method = $this->http_method;

        $matches = array_map(function ($path) use ($method) {
            $path = 'api/admin/' . trim($path, '/');

            if (\Illuminate\Support\Str::contains($path, ':')) {
                list($method, $path) = explode(':', $path);
                $method = explode(',', $method);
            }

            return compact('method', 'path');
        }, explode("\n", $this->http_path));

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
}
