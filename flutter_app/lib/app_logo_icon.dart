import 'package:flutter/material.dart';

class AppLogoIcon extends StatelessWidget {
  final double size;

  const AppLogoIcon({super.key, this.size = 60.0});

  @override
  Widget build(BuildContext context) {
    return Container(
      width: size,
      height: size,
      decoration: BoxDecoration(
        shape: BoxShape.circle,
        border: Border.all(
          color: const Color(0xFF8b5cf6).withOpacity(0.6),
          width: 2,
        ),
      ),
      child: const Center(
        child: Icon(
          Icons.qr_code,
          color: Color(0xFF06b6d4),
          size: 40,
        ),
      ),
    );
  }
}
