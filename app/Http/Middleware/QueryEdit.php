<?php

namespace App\Http\Middleware;

use App\Classes\Constants\AlertMessages;
use App\Classes\Constants\RolesConstants;
use Closure;
use Illuminate\Http\Request;

class QueryEdit
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
        if(RolesConstants::isLogist() || RolesConstants::isAdmin() || RolesConstants::isManager() || RolesConstants::isResponsibleForDrivers()){
            return $next($request);
        }
        return redirect()->route('home')->with([
            'alertMessage' => AlertMessages::ACCESS_DENIED,
        ]);
    }
}
