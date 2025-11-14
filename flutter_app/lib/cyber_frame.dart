import 'package:flutter/material.dart';

class CyberFrame extends StatelessWidget {
  final Widget child;

  const CyberFrame({super.key, required this.child});

  @override
  Widget build(BuildContext context) {
    return ClipPath(
      clipper: CyberFrameClipper(),
      child: Container(
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(16.0),
          border: Border.all(
            color: const Color(0xFF06b6d4).withOpacity(0.3),
            width: 2,
          ),
          gradient: LinearGradient(
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
            colors: [
              const Color(0xFF1e293b).withOpacity(0.8),
              const Color(0xFF0f172a).withOpacity(0.8),
            ],
          ),
        ),
        child: child,
      ),
    );
  }
}

class CyberFrameClipper extends CustomClipper<Path> {
  @override
  Path getClip(Size size) {
    final path = Path();
    path.moveTo(0, 0);
    path.lineTo(size.width - 20, 0);
    path.lineTo(size.width, 20);
    path.lineTo(size.width, size.height);
    path.lineTo(20, size.height);
    path.lineTo(0, size.height - 20);
    path.close();
    return path;
  }

  @override
  bool shouldReclip(CustomClipper<Path> oldClipper) => false;
}
