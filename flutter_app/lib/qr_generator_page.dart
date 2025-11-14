import 'package:flutter/material.dart';
import 'package:qr_flutter/qr_flutter.dart';

class QrGeneratorPage extends StatefulWidget {
  const QrGeneratorPage({super.key});

  @override
  State<QrGeneratorPage> createState() => _QrGeneratorPageState();
}

class _QrGeneratorPageState extends State<QrGeneratorPage> {
  String? _paymentMethod;
  final _amountController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Generate QR Code'),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Choose Payment Method',
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 16),
            _buildPaymentMethodSelector(),
            const SizedBox(height: 24),
            if (_paymentMethod != null) _buildQrCodeSection(),
          ],
        ),
      ),
    );
  }

  Widget _buildPaymentMethodSelector() {
    return Row(
      children: [
        Expanded(
          child: _PaymentMethodCard(
            methodName: 'GCash',
            isSelected: _paymentMethod == 'gcash',
            onTap: () => setState(() => _paymentMethod = 'gcash'),
          ),
        ),
        const SizedBox(width: 16),
        Expanded(
          child: _PaymentMethodCard(
            methodName: 'PayMaya',
            isSelected: _paymentMethod == 'paymaya',
            onTap: () => setState(() => _paymentMethod = 'paymaya'),
          ),
        ),
      ],
    );
  }

  Widget _buildQrCodeSection() {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            Text(
              '${_paymentMethod == 'gcash' ? 'GCash' : 'PayMaya'} QR Code',
              style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 16),
            QrImageView(
              data: _paymentMethod == 'gcash'
                  ? '00020101021126650014com.gcash0111+639171234567...'
                  : '00020101021126660014com.paymaya0111+639191234567...',
              version: QrVersions.auto,
              size: 200.0,
            ),
            const SizedBox(height: 16),
            TextField(
              controller: _amountController,
              keyboardType: TextInputType.number,
              decoration: const InputDecoration(
                labelText: 'Amount',
                border: OutlineInputBorder(),
              ),
            ),
            const SizedBox(height: 16),
            ElevatedButton(
              onPressed: () {},
              child: const Text('Record Payment'),
            ),
          ],
        ),
      ),
    );
  }
}

class _PaymentMethodCard extends StatelessWidget {
  final String methodName;
  final bool isSelected;
  final VoidCallback onTap;

  const _PaymentMethodCard({
    required this.methodName,
    required this.isSelected,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Card(
        color: isSelected ? Colors.blue : null,
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Text(
            methodName,
            style: TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
              color: isSelected ? Colors.white : null,
            ),
          ),
        ),
      ),
    );
  }
}
