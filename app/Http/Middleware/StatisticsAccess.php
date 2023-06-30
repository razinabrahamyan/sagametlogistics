<?php

namespace App\Http\Middleware;

use App\Classes\Constants\AlertMessages;
use App\Classes\Constants\RolesConstants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticsAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $isUserHasAccess = in_array(Auth::id(), [1, 9]);
        if (RolesConstants::isAdmin() || $isUserHasAccess) {
            return $next($request);
        }
        return redirect()->route('home')->with([
            'alertMessage' => AlertMessages::ACCESS_DENIED,
        ]);
    }
}
