<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register'); // Fixed path - should be 'Auth/Register' not 'auth/Register'
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'studentId' => 'nullable|string|max:50|unique:users,student_id',
            'program' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Combine names
        $fullName = trim($request->firstName . ' ' . ($request->middleName ? $request->middleName . ' ' : '') . $request->lastName);

        $user = User::create([
            'name' => $fullName,
            'first_name' => $request->firstName, // Store individual names if needed
            'middle_name' => $request->middleName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'student_id' => $request->studentId,
            'program' => $request->program,
            'year_level' => $request->year, // Changed to match your database column
            'role' => 'Member', // Default role
            'status' => 'pending', // Changed to 'pending' for consistency
        ]);

        // Fire the Registered event (optional, for notifications)
        event(new Registered($user));

        // Redirect to the pending page instead of back to register
        return redirect()->route('registration.pending')->with([
            'registration_pending' => true,
            'email' => $request->email // Optional: pass email to show on pending page
        ]);
    }
}