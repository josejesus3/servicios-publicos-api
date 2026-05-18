<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin {
    /**
    * Handle an incoming request.
    *
    * @param  Closure( Request ): ( Response )  $next
    */

    public function handle( Request $request, Closure $next ): Response {
        if ( !auth()->check() || auth()->user()->role_id !== 1 ) {
            return response()->json( [
                'message' => 'No autorizado'
            ], 403 );
        }
        return $next( $request );
    }
}
