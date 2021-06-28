<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke() : \Inertia\Response
    {
        return Inertia::render('Dashboard/Dashboard');
    }
}
