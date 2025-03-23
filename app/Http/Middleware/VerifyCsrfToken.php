<?php
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*',     // ✅ Exclude all API routes
        'test',      // ✅ Exclude test route
        'admin/logout', // ✅ Exclude logout
    ];
}

