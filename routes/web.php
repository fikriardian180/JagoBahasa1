<?php

use App\Http\Controllers\AccessibilityController;
use App\Http\Controllers\ProfileController;
use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Accessibility Preferences Sync
Route::patch('/preferences/accessibility', [AccessibilityController::class, 'update']);

// Demo Login for Judges
Route::get('/demo-login/{role}', function ($role) {
    if (!config('lms.seed_demo')) {
        abort(404);
    }
    $user = User::where('role', $role)->first();
    if ($user) {
        auth()->login($user);
        return redirect()->route('dashboard');
    }
    return redirect()->route('login')->with('error', 'Demo user not found for role: ' . $role);
})->name('demo.login');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if (in_array($user->role, ['admin', 'lecturer'])) {
        return view('admin.dashboard', compact('user'));
    }
    return view('student.dashboard', compact('user'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Classroom Join
    Route::post('/classrooms/join', function (Request $request) {
        $request->validate(['join_code' => 'required|string']);
        $classroom = Classroom::where('join_code', $request->join_code)->where('is_active', true)->first();
        if (! $classroom) {
            return back()->withErrors(['join_code' => 'Kode kelas tidak valid atau sudah tidak aktif.']);
        }
        Enrollment::firstOrCreate([
            'classroom_id' => $classroom->id,
            'user_id' => auth()->id(),
        ], [
            'joined_at' => now(),
        ]);
        return redirect()->route('dashboard')->with('success', 'Berhasil bergabung ke kelas ' . $classroom->name);
    })->name('classrooms.join');
});

require __DIR__.'/auth.php';
