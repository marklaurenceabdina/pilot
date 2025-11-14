import 'package:flutter/material.dart';

class CyberCard extends StatelessWidget {
  final Widget child;

  const CyberCard({super.key, required this.child});

  @override
  Widget build(BuildContext context) {
    return ClipPath(
      clipper: CyberCardClipper(),
      child: Container(
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(12.0),
          border: Border.all(
            color: const Color(0xFF334155).withOpacity(0.5),
            width: 1,
          ),
          color: const Color(0xFF1e293b).withOpacity(0.4),
        ),
        child: child,
      ),
    );
  }
}

class CyberCardClipper extends CustomClipper<Path> {
  @override
  Path getClip(Size size) {
    final path = Path();
    path.moveTo(0, 0);
    path.lineTo(size.width - 15, 0);
    path.lineTo(size.width, 15);
    path.lineTo(size.width, size.height);
    path.lineTo(15, size.height);
    path.lineTo(0, size.height - 15);
    path.close();
    return path;
  }

  @override
  bool shouldReclip(CustomClipper<Path> oldClipper) => false;
}
