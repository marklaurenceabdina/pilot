<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return response()->json([
            'totalUsers' => DB::table('users')->count(),
            'activeUsers' => DB::table('users')->where('account_status', 'active')->count(),

            'totalPayments' => DB::table('payments')->count(),
            'totalRevenue' => DB::table('payments')->where('payment_status', 'completed')->sum('amount'),

            'totalEvents' => DB::table('events')->count(),
            'activeEvents' => DB::table('events')->where('status', 'active')->count(),

            'totalTransactions' => DB::table('financialtransactions')->count(),
            'approvedTransactions' => DB::table('financialtransactions')->where('approval_status', 'approved')->count(),
        ]);
    }
}
