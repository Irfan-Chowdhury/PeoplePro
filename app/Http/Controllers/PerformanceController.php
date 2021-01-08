<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function indexGoalType()
    {
        return view('performance.goal-type.index');
    }

    public function indexGoalTracking()
    {
        return view('performance.goal-tracking.index');
    }

    public function indexIndicator()
    {
        return view('performance.indicator.index');
    }

    public function indexAppraisal()
    {
        // return view('performance.goal-type.index');
    }
}
