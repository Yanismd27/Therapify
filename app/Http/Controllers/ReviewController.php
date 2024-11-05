<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function store(Request $request, Appointment $appointment)
    {
        Gate::authorize('create', [Review::class, $appointment]);

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean'
        ]);

        $review = Review::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'therapist_id' => $appointment->therapist_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_anonymous' => $validated['is_anonymous'] ?? false
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

    public function update(Request $request, Review $review)
    {
        Gate::authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean'
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}