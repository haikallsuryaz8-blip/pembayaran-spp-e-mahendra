<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::guard('petugas')->check()) {
            $userRole = Auth::guard('petugas')->user()->level;
            if (in_array($userRole, $roles)) {
                return $next($request);
            }
        }

        if (Auth::guard('siswa')->check()) {
            if (in_array('siswa', $roles)) {
                return $next($request);
            }
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut!');
    }
}
