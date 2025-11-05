<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceUtf8Headers
{
    /**
     * Ensure all text responses explicitly declare UTF-8 charset.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            $contentType = $response->headers->get('Content-Type');
            if ($contentType) {
                $lower = strtolower($contentType);
                if (
                    str_contains($lower, 'text/html') ||
                    str_contains($lower, 'application/json') ||
                    str_contains($lower, 'text/plain') ||
                    str_contains($lower, 'application/javascript') ||
                    str_contains($lower, 'text/css')
                ) {
                    if (!str_contains($lower, 'charset')) {
                        $response->headers->set('Content-Type', $contentType . '; charset=UTF-8');
                    } else {
                        $response->headers->set('Content-Type', preg_replace('/charset=([^;]+)/i', 'charset=UTF-8', $contentType));
                    }
                }
            } else {
                $response->headers->set('Content-Type', 'text/html; charset=UTF-8');
            }

            // Prevent MIME-type sniffing
            $response->headers->set('X-Content-Type-Options', 'nosniff');
        } catch (\Throwable $e) {
            $response->headers->set('Content-Type', 'text/html; charset=UTF-8');
        }

        return $response;
    }
}
