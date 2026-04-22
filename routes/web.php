<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'stats' => [
            'stack' => ['Laravel 13', 'Inertia.js', 'Vue 3', 'TypeScript', 'Tailwind CSS', 'Vite'],
            'pillars' => ['Type-safe UI', 'Shared page data', 'Scalable page loading', 'Production build pipeline'],
        ],
    ]);
});
