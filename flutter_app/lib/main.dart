import 'package:flutter/material.dart';
import 'package:flutter_app/app_router.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'PSITS Nexus',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      initialRoute: AppRouter.welcomeRoute,
      onGenerateRoute: AppRouter.generateRoute,
    );
  }
}
