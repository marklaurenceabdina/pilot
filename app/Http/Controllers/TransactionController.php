<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = strtolower($user->role ?? '') === 'admin';

        $transactions = $isAdmin
            ? Transaction::with('user')->latest()->get()
            : Transaction::with('user')->where('user_id', $user->id)->latest()->get();

        // Map for frontend (Inertia)
        $payload = $transactions->map(function ($tx) {
            return [
                'id' => $tx->id,
                'date' => $tx->created_at->format('Y-m-d'),
                'type' => $tx->type,
                'description' => $tx->description,
                'amount' => $tx->amount,
                'status' => $tx->status,
                'user' => $tx->user->name ?? null,
            ];
        });

        return inertia('TransactionHistory', [
            'transactions' => $payload,
            'isAdmin' => $isAdmin,
        ]);
    }

    // Export all transactions as CSV
    public function exportCsv(): StreamedResponse
    {
        $user = Auth::user();

        $transactions = $user->role === 'Admin'
            ? Transaction::with('user')->get()
            : Transaction::with('user')->where('user_id', $user->id)->get();

        $filename = 'transactions.csv';

        return response()->streamDownload(function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['User', 'Date', 'Type', 'Description', 'Amount', 'Status']);

            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    $transaction->user->name ?? '',
                    $transaction->created_at->format('Y-m-d'),
                    ucfirst($transaction->type),
                    $transaction->description,
                    number_format($transaction->amount, 2),
                    $transaction->status,
                ]);
            }

            fclose($handle);
        }, 'transactions.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    // Export all transactions as PDF
    public function exportPdf()
    {
        $user = Auth::user();

        $transactions = $user->role === 'Admin'
            ? Transaction::with('user')->get()
            : Transaction::with('user')->where('user_id', $user->id)->get();

        $pdf = Pdf::loadView('receipts.transactions_all', [
            'transactions' => $transactions,
            'isAdmin' => $user->role === 'Admin',
        ]);

        return $pdf->download('transactions.pdf'); // fixed filename for tests
    }

    // Download individual transaction receipt
    public function receipt($id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);

        $user = Auth::user();

        // Only allow the owner or admin
        if ($transaction->user_id !== $user->id && $user->role !== 'Admin') {
            abort(403); // Forbidden
        }

        $pdf = Pdf::loadView('transactions.receipt', [
            'transaction' => $transaction,
        ]);

        return $pdf->download('receipt-' . $transaction->id . '.pdf'); // match test
    }
}
