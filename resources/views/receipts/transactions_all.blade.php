<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All Transactions</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Transaction History</h1>
    <p>{{ $isAdmin ? 'Admin View: All Transactions' : 'Your Transactions' }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Date</th>
                <th>Type</th>
                <th>Description</th>
                <th>Amount (₱)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                    <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ $transaction->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
