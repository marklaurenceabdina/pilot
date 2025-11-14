import 'package:flutter/material.dart';

class TransactionHistoryPage extends StatefulWidget {
  const TransactionHistoryPage({super.key});

  @override
  State<TransactionHistoryPage> createState() => _TransactionHistoryPageState();
}

class _TransactionHistoryPageState extends State<TransactionHistoryPage> {
  String _searchQuery = '';
  String? _filterType;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Transaction History'),
        actions: [
          TextButton.icon(
            onPressed: () {},
            icon: const Icon(Icons.download),
            label: const Text('Export CSV'),
          ),
          TextButton.icon(
            onPressed: () {},
            icon: const Icon(Icons.picture_as_pdf),
            label: const Text('Export PDF'),
          ),
        ],
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            _buildFilters(),
            const SizedBox(height: 24),
            _buildTransactionsTable(),
            const SizedBox(height: 24),
            _buildPagination(),
          ],
        ),
      ),
    );
  }

  Widget _buildFilters() {
    return Row(
      children: [
        Expanded(
          child: TextField(
            onChanged: (value) => setState(() => _searchQuery = value),
            decoration: const InputDecoration(
              labelText: 'Search transactions...',
              border: OutlineInputBorder(),
            ),
          ),
        ),
        const SizedBox(width: 16),
        DropdownButtonFormField<String>(
          value: _filterType,
          decoration: const InputDecoration(
            labelText: 'Type',
            border: OutlineInputBorder(),
          ),
          items: const [
            DropdownMenuItem(value: 'all', child: Text('All Types')),
            DropdownMenuItem(value: 'payment', child: Text('Payment')),
            DropdownMenuItem(value: 'expense', child: Text('Expense')),
            DropdownMenuItem(value: 'membership', child: Text('Membership')),
          ],
          onChanged: (value) => setState(() => _filterType = value),
        ),
      ],
    );
  }

  Widget _buildTransactionsTable() {
    // Dummy data for now
    final transactions = List.generate(
      10,
      (index) => {
        'date': '2024-01-${index + 1}',
        'type': 'Payment',
        'description': 'Transaction ${index + 1}',
        'amount': '₱100.00',
        'status': 'Completed',
      },
    );

    return DataTable(
      columns: const [
        DataColumn(label: Text('Date')),
        DataColumn(label: Text('Type')),
        DataColumn(label: Text('Description')),
        DataColumn(label: Text('Amount')),
        DataColumn(label: Text('Status')),
      ],
      rows: transactions.map((tx) {
        return DataRow(
          cells: [
            DataCell(Text(tx['date']!)),
            DataCell(Text(tx['type']!)),
            DataCell(Text(tx['description']!)),
            DataCell(Text(tx['amount']!)),
            DataCell(Chip(label: Text(tx['status']!))),
          ],
        );
      }).toList(),
    );
  }

  Widget _buildPagination() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        const Text('Showing 10 of 100 transactions'),
        Row(
          children: [
            TextButton(onPressed: () {}, child: const Text('Prev')),
            TextButton(onPressed: () {}, child: const Text('Next')),
          ],
        ),
      ],
    );
  }
}
