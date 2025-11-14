import 'dart:async';
import 'package:flutter/material.dart';
import 'package:flutter_app/app_logo_icon.dart';
import 'package:flutter_app/app_router.dart';
import 'package:flutter_app/cyber_card.dart';
import 'package:flutter_app/cyber_frame.dart';
import 'package:flutter_app/gradient_text.dart';

class WelcomePage extends StatefulWidget {
  const WelcomePage({super.key});

  @override
  State<WelcomePage> createState() => _WelcomePageState();
}

class _WelcomePageState extends State<WelcomePage> {
  int _activeFeature = 0;
  Timer? _timer;

  final _features = [
    {
      'title': 'Instant QR Payments',
      'description':
          'Generate and scan QR codes for seamless transactions with real-time processing.',
      'icon': Icons.qr_code_scanner,
    },
    {
      'title': 'Neural Analytics',
      'description':
          'AI-powered financial insights with quantum-speed data processing.',
      'icon': Icons.insights,
    },
    {
      'title': 'Quantum Automation',
      'description':
          'Lightning-fast automation powered by next-gen algorithms.',
      'icon': Icons.bolt,
    },
    {
      'title': 'Hive Mind Connect',
      'description':
          'Advanced member engagement with predictive behavior analytics.',
      'icon': Icons.groups,
    },
  ];

  @override
  void initState() {
    super.initState();
    _timer = Timer.periodic(const Duration(seconds: 4), (timer) {
      setState(() {
        _activeFeature = (_activeFeature + 1) % _features.length;
      });
    });
  }

  @override
  void dispose() {
    _timer?.cancel();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
            colors: [
              Color(0xFF0f172a),
              Color(0xFF1e293b),
              Color(0xFF334155),
            ],
          ),
        ),
        child: SafeArea(
          child: SingleChildScrollView(
            child: Column(
              children: [
                _buildNavBar(),
                _buildHeroSection(),
                _buildFeaturesSection(),
                _buildCtaSection(),
                _buildFooter(),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildNavBar() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 20.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          const Row(
            children: [
              AppLogoIcon(),
              SizedBox(width: 12),
              Text(
                'PSITS NEXUS',
                style: TextStyle(
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                  color: Colors.white,
                ),
              ),
            ],
          ),
          Row(
            children: [
              TextButton(
                onPressed: () =>
                    Navigator.pushNamed(context, AppRouter.loginRoute),
                child: const Text(
                  'SIGN IN',
                  style: TextStyle(color: Colors.white),
                ),
              ),
              const SizedBox(width: 12),
              ElevatedButton(
                onPressed: () =>
                    Navigator.pushNamed(context, AppRouter.registerRoute),
                child: const Text('JOIN US!'),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildHeroSection() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 40.0),
      child: LayoutBuilder(
        builder: (context, constraints) {
          if (constraints.maxWidth > 800) {
            return Row(
              children: [
                Expanded(
                  child: _buildHeroText(),
                ),
                Expanded(
                  child: _buildHeroVisual(),
                ),
              ],
            );
          } else {
            return Column(
              children: [
                _buildHeroText(),
                const SizedBox(height: 40),
                _buildHeroVisual(),
              ],
            );
          }
        },
      ),
    );
  }

  Widget _buildHeroText() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Philippine Society of',
          style: TextStyle(
            fontSize: 40,
            fontWeight: FontWeight.bold,
            color: Colors.white,
          ),
        ),
        const GradientText(
          'Information Technology',
          gradient: LinearGradient(
            colors: [
              Color(0xFF06b6d4),
              Color(0xFF8b5cf6),
              Color(0xFFec4899),
            ],
          ),
          style: TextStyle(
            fontSize: 40,
            fontWeight: FontWeight.bold,
          ),
        ),
        const SizedBox(height: 20),
        const Text(
          'Enter the next dimension of digital transactions. PSITS Nexus delivers quantum-speed QR payments, AI-powered automation, and neural analytics.',
          style: TextStyle(
            fontSize: 18,
            color: Colors.white70,
          ),
        ),
        const SizedBox(height: 30),
        Row(
          children: [
            ElevatedButton(
              onPressed: () =>
                  Navigator.pushNamed(context, AppRouter.registerRoute),
              child: const Text('Join us Now'),
            ),
            const SizedBox(width: 20),
            OutlinedButton(
              onPressed: () {},
              child: const Text('What we Offer?'),
            ),
          ],
        ),
      ],
    );
  }

  Widget _buildHeroVisual() {
    return CyberFrame(
      child: AspectRatio(
        aspectRatio: 1,
        child: Stack(
          children: List.generate(_features.length, (index) {
            final feature = _features[index];
            return AnimatedOpacity(
              duration: const Duration(milliseconds: 700),
              opacity: _activeFeature == index ? 1.0 : 0.0,
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(
                    feature['icon'] as IconData,
                    size: 80,
                    color: const Color(0xFF06b6d4),
                  ),
                  const SizedBox(height: 20),
                  Text(
                    feature['title'] as String,
                    textAlign: TextAlign.center,
                    style: const TextStyle(
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                    ),
                  ),
                  const SizedBox(height: 10),
                  Text(
                    feature['description'] as String,
                    textAlign: TextAlign.center,
                    style: const TextStyle(
                      fontSize: 16,
                      color: Colors.white70,
                    ),
                  ),
                ],
              ),
            );
          }),
        ),
      ),
    );
  }

  Widget _buildFeaturesSection() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 80.0),
      child: Column(
        children: [
          const GradientText(
            'PSITS NEXUS CAPABILITIES',
            gradient: LinearGradient(
              colors: [
                Color(0xFF06b6d4),
                Color(0xFF8b5cf6),
                Color(0xFFec4899),
              ],
            ),
            style: TextStyle(
              fontSize: 32,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 20),
          const Text(
            'Harness the power of quantum computing and artificial intelligence to revolutionize your organization\'s financial ecosystem with bleeding-edge technology.',
            textAlign: TextAlign.center,
            style: TextStyle(
              fontSize: 18,
              color: Colors.white70,
            ),
          ),
          const SizedBox(height: 40),
          LayoutBuilder(
            builder: (context, constraints) {
              int crossAxisCount;
              if (constraints.maxWidth > 1200) {
                crossAxisCount = 4;
              } else if (constraints.maxWidth > 800) {
                crossAxisCount = 2;
              } else {
                crossAxisCount = 1;
              }
              return GridView.builder(
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: crossAxisCount,
                  crossAxisSpacing: 20,
                  mainAxisSpacing: 20,
                  childAspectRatio: 1.2,
                ),
                itemCount: _features.length,
                itemBuilder: (context, index) {
                  final feature = _features[index];
                  return CyberCard(
                    child: Padding(
                      padding: const EdgeInsets.all(16.0),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Icon(
                            feature['icon'] as IconData,
                            size: 40,
                            color: const Color(0xFF06b6d4),
                          ),
                          const SizedBox(height: 20),
                          Text(
                            feature['title'] as String,
                            style: const TextStyle(
                              fontSize: 20,
                              fontWeight: FontWeight.bold,
                              color: Colors.white,
                            ),
                          ),
                          const SizedBox(height: 10),
                          Expanded(
                            child: Text(
                              feature['description'] as String,
                              style: const TextStyle(
                                fontSize: 16,
                                color: Colors.white70,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                  );
                },
              );
            },
          ),
        ],
      ),
    );
  }

  Widget _buildCtaSection() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 80.0),
      child: Column(
        children: [
          const GradientText(
            'READY TO JOIN THE PSITS-NEXUS?',
            gradient: LinearGradient(
              colors: [
                Color(0xFF06b6d4),
                Color(0xFF8b5cf6),
              ],
            ),
            style: TextStyle(
              fontSize: 32,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 20),
          const Text(
            'Join the evolution. Thousands of neural organizations are already using PSITS Nexus to quantum-leap their financial operations into the future.',
            textAlign: TextAlign.center,
            style: TextStyle(
              fontSize: 18,
              color: Colors.white70,
            ),
          ),
          const SizedBox(height: 40),
          ElevatedButton(
            onPressed: () =>
                Navigator.pushNamed(context, AppRouter.registerRoute),
            child: const Text('SIGN UP HERE'),
          ),
        ],
      ),
    );
  }

  Widget _buildFooter() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 40.0),
      child: Column(
        children: [
          LayoutBuilder(
            builder: (context, constraints) {
              if (constraints.maxWidth > 800) {
                return Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    _buildFooterLogo(),
                    _buildFooterLinks(),
                  ],
                );
              } else {
                return Column(
                  children: [
                    _buildFooterLogo(),
                    const SizedBox(height: 20),
                    _buildFooterLinks(),
                  ],
                );
              }
            },
          ),
          const SizedBox(height: 20),
          const Divider(color: Colors.white24),
          const SizedBox(height: 20),
          const Text(
            '© 2077 PSITS NEXUS CORP. // ALL NEURAL RIGHTS RESERVED // QUANTUM ENCRYPTED',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: Colors.white54,
              fontSize: 12,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildFooterLogo() {
    return const Row(
      mainAxisSize: MainAxisSize.min,
      children: [
        AppLogoIcon(size: 40),
        SizedBox(width: 12),
        Text(
          'PSITS NEXUS',
          style: TextStyle(
            fontSize: 16,
            fontWeight: FontWeight.bold,
            color: Colors.white,
          ),
        ),
      ],
    );
  }

  Widget _buildFooterLinks() {
    return Row(
      mainAxisSize: MainAxisSize.min,
      children: [
        TextButton(
          onPressed: () {},
          child: const Text('PROTOCOLS'),
        ),
        TextButton(
          onPressed: () {},
          child: const Text('PRIVACY_MATRIX'),
        ),
        TextButton(
          onPressed: () {},
          child: const Text('NEURAL_LINK'),
        ),
      ],
    );
  }
}
