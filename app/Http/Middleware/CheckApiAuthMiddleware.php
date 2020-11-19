<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('Authorization')) {
            http_response_code(401);

            header("Content-Type: application/json");
            $data = ['error' => 'Please specify `Authorization` header!'];
            die(json_encode($data));
            //return response()->json(['error' => 'Please specify `Authorization` header!'], Response::HTTP_UNAUTHORIZED);
        }

        $bearerToken = explode(" ", $request->header('Authorization'))[1] ?? null;

        /** @var User|null $user */
        $user = User::query()->where('token', $bearerToken)->first();

        if (!$user) {
            http_response_code(401);
            header("Content-Type: application/json");
            $data = ['error' => 'Token is invalid!'];
            die(json_encode($data));
            //return response()->json(['error' => 'Token is invalid!'], Response::HTTP_UNAUTHORIZED);
        }

        Auth::login($user);

        return $next($request);
    }
}
