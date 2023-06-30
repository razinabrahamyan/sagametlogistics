<?php

namespace App\Http\Middleware;

use App\Classes\Constants\AlertMessages;
use App\Classes\Constants\RolesConstants;
use Closure;
use Illuminate\Http\Request;

class LogisticsPersonnel
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
        if (RolesConstants::isLogisticPersonnel()) {
            return $next($request);
        }

        return redirect()->route('home')->with([
            'alertMessage' => AlertMessages::ACCESS_DENIED,
        ]);
    }
}
