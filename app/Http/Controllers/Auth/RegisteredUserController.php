<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $email = $request->email;
        $role = 'guest';
        $institutionId = null;
        $isInstitutional = false;

        // Check domain mapping against institutions table
        $domain = substr(strrchr($email, "@"), 1);
        $institution = Institution::where('email_domain', $domain)->first();

        if ($institution) {
            $institutionId = $institution->id;
            $isInstitutional = true;
            $role = str_contains($email, 'student') ? 'student' : $institution->default_role;
        } elseif (str_contains($email, 'student.')) {
            $role = 'student';
            $isInstitutional = true;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'institution_id' => $institutionId,
            'is_institutional' => $isInstitutional,
            'email_verified_at' => config('lms.seed_demo') ? now() : null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
