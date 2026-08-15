<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est connecté et s'il possède le rôle admin
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        // Redirection ou erreur 403 si non autorisé
        abort(403, 'Accès non autorisé. Espace réservé aux administrateurs.');
    }
}
