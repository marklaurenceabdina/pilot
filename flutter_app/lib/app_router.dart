import 'package:flutter/material.dart';
import 'package:flutter_app/dashboard_page.dart';
import 'package:flutter_app/pages/auth/login_page.dart';
import 'package:flutter_app/pages/auth/register_page.dart';
import 'package:flutter_app/qr_generator_page.dart';
import 'package:flutter_app/transaction_history_page.dart';
import 'package:flutter_app/welcome_page.dart';

class AppRouter {
  static const String welcomeRoute = '/';
  static const String loginRoute = '/login';
  static const String registerRoute = '/register';
  static const String dashboardRoute = '/dashboard';
  static const String transactionHistoryRoute = '/transactions';
  static const String qrGeneratorRoute = '/qr-generator';

  static Route<dynamic> generateRoute(RouteSettings settings) {
    switch (settings.name) {
      case welcomeRoute:
        return MaterialPageRoute(builder: (_) => const WelcomePage());
      case loginRoute:
        return MaterialPageRoute(builder: (_) => const LoginPage());
      case registerRoute:
        return MaterialPageRoute(builder: (_) => const RegisterPage());
      case dashboardRoute:
        return MaterialPageRoute(builder: (_) => const DashboardPage());
      case transactionHistoryRoute:
        return MaterialPageRoute(builder: (_) => const TransactionHistoryPage());
      case qrGeneratorRoute:
        return MaterialPageRoute(builder: (_) => const QrGeneratorPage());
      default:
        return MaterialPageRoute(
          builder: (_) => Scaffold(
            body: Center(
              child: Text('No route defined for ${settings.name}'),
            ),
          ),
        );
    }
  }
}
