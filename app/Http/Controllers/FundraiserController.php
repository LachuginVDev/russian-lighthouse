<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Fundraiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class FundraiserController extends Controller
{
    public function index(Request $request): Response
    {
        $items = Fundraiser::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Fundraiser $f) => [
                'id' => $f->id,
                'title' => $f->title,
                'excerpt' => $f->description ? \Illuminate\Support\Str::limit(strip_tags($f->description), 160) : null,
                'goal' => (float) $f->goal,
                'raised' => (float) $f->raised,
                'href' => route('fundraisers.show', $f->id),
            ]);

        return Inertia::render('Fundraisers/Index', [
            'items' => $items,
            'canLogin' => \Illuminate\Support\Facades\Route::has('login'),
            'canRegister' => \Illuminate\Support\Facades\Route::has('register'),
        ]);
    }

    public function show(Request $request, int $id): Response
    {
        $fundraiser = Fundraiser::query()
            ->where('is_active', true)
            ->find($id);

        $publicProps = [
            'canLogin' => \Illuminate\Support\Facades\Route::has('login'),
            'canRegister' => \Illuminate\Support\Facades\Route::has('register'),
        ];

        if (! $fundraiser) {
            return Inertia::render('Fundraisers/Show', [
                'id' => $id,
                'fundraiser' => null,
                ...$publicProps,
            ]);
        }

        $canonicalUrl = url()->route('fundraisers.show', $fundraiser->id);

        return Inertia::render('Fundraisers/Show', [
            'id' => $fundraiser->id,
            'fundraiser' => [
                'title' => $fundraiser->title,
                'description' => $fundraiser->description,
                'goal' => (float) $fundraiser->goal,
                'raised' => (float) $fundraiser->raised,
                'meta_title' => $fundraiser->meta_title,
                'meta_description' => $fundraiser->meta_description,
                'og_image' => $fundraiser->og_image
                    ? Storage::disk('public')->url($fundraiser->og_image)
                    : null,
                'canonical_url' => $canonicalUrl,
            ],
            ...$publicProps,
        ]);
    }

    public function storeDonation(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $fundraiser = Fundraiser::query()->where('is_active', true)->findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|email',
            'message' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
        ]);

        $fundraiser->donations()->create([
            'amount' => $validated['amount'],
            'donor_name' => $validated['is_anonymous'] ?? false ? null : ($validated['donor_name'] ?? null),
            'donor_email' => $validated['is_anonymous'] ?? false ? null : ($validated['donor_email'] ?? null),
            'message' => $validated['message'] ?? null,
            'is_anonymous' => $validated['is_anonymous'] ?? false,
        ]);

        $fundraiser->increment('raised', $validated['amount']);

        return back()->with('status', 'Спасибо! Пожертвование учтено.');
    }
}
