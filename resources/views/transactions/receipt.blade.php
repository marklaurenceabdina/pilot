<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transaction Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        h1 { text-align: center; margin-bottom: 30px; }
        .details { margin: 0 auto; width: 60%; }
        .details p { margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Transaction Receipt</h1>

    <div class="details">
        <p><strong>Transaction ID:</strong> {{ $transaction->id }}</p>
        <p><strong>Date:</strong> {{ $transaction->created_at->format('Y-m-d') }}</p>
        <p><strong>User:</strong> {{ $transaction->user->name ?? 'N/A' }}</p>
        <p><strong>Type:</strong> {{ ucfirst($transaction->type) }}</p>
        <p><strong>Description:</strong> {{ $transaction->description }}</p>
        <p><strong>Amount:</strong> ₱{{ number_format($transaction->amount, 2) }}</p>
        <p><strong>Status:</strong> {{ $transaction->status }}</p>
    </div>
</body>
</html>
