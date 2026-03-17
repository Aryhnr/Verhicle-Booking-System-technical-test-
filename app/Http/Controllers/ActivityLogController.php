<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->date, fn($q) => $q->whereDate('created_at', $request->date))
            ->latest('created_at')
            ->paginate(20);

        return view('admin.activity-logs.index', compact('logs'));
    }
}