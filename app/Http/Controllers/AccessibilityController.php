<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccessibilityController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $validated = $request->validate([
                'font_scale' => 'nullable|string',
                'high_contrast' => 'nullable|boolean',
                'dyslexic_font' => 'nullable|boolean',
                'reduce_motion' => 'nullable|boolean',
            ]);

            $prefs = $user->accessibility_prefs ?? [];
            $newPrefs = array_merge($prefs, $validated);
            $user->update(['accessibility_prefs' => $newPrefs]);

            return response()->json(['success' => true, 'prefs' => $newPrefs]);
        }

        return response()->json(['success' => true, 'guest' => true]);
    }
}
