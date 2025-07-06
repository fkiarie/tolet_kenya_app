<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 8px 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <h2>Tolet Kenya - Payment Report</h2>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Tenant</th>
                <th>Unit</th>
                <th>Month</th>
                <th>Amount</th>
                <th>Commission</th>
                <th>Landlord</th>
                <th>Method</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $p)
                <tr>
                    <td>{{ $p->formatted_date }}</td>
                    <td>{{ $p->tenant->full_name }}</td>
                    <td>{{ $p->unit->house_number ?? '-' }}</td>
                    <td>{{ $p->formatted_month }}</td>
                    <td>KSh {{ number_format($p->amount, 2) }}</td>
                    <td>KSh {{ number_format($p->commission_amount, 2) }} ({{ $p->commission_rate }}%)</td>
                    <td>KSh {{ number_format($p->landlord_amount, 2) }}</td>
                    <td>{{ $p->method }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
