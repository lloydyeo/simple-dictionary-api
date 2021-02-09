<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePayloadIsValidJson
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
        if (!$request->isJson()) {
            $content_type = empty($request->getContentType()) ? $request->getContentType() : 'null';
            return response()->json([
                'status' => false,
                'error' => 'JSON expected. Got Content-Type: ' . $content_type . ' instead.'
            ], 400);
        }

        if (!$request->json()->count()) {
            return response()->json([
                'status' => false,
                'error' => 'Malformed JSON received. Please check your input.'
            ], 400);
        }

        return $next($request);
    }
}
