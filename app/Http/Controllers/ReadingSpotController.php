<?php

namespace App\Http\Controllers;

use App\Models\AppProfile;
use App\Models\CheckoutSetting;
use App\Models\ReadingSpot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReadingSpotController extends Controller
{
    public function index(Request $r)
    {
        $spots = ReadingSpot::withCount(['members','books','offlineBooks'])
            ->when($r->q, fn($q) => $q->where('name', 'like', "%{$r->q}%"))
            ->when($r->type, fn($q) => $q->where('type', $r->type))
            ->latest()->paginate(20)->withQueryString();
        return view('reading-spots.index', compact('spots'));
    }

    public function create() { return view('reading-spots.create'); }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:school,library,community,public',
            'npsn'        => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'province'    => 'nullable|string|max:100',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',
            'phone'       => 'nullable|string|max:30',
            'email'       => 'nullable|email',
            'description' => 'nullable|string',
            'logo'        => 'nullable|image|max:2048',
        ]);
        $data['slug'] = Str::slug($data['name']);
        if ($r->hasFile('logo')) $data['logo'] = $r->file('logo')->store('reading-spots', 'public');
        $spot = ReadingSpot::create($data);

        AppProfile::firstOrCreate(['reading_spot_id' => $spot->id], ['app_name' => $spot->name]);
        CheckoutSetting::firstOrCreate(['reading_spot_id' => $spot->id]);

        return redirect()->route('reading-spots.show', $spot)->with('toast', 'Reading Spot dibuat.');
    }

    public function show(ReadingSpot $readingSpot)
    {
        $readingSpot->load(['profile','checkoutSetting','users']);
        $stats = [
            'members'        => $readingSpot->members()->count(),
            'books'          => $readingSpot->books()->count(),
            'offline_books'  => $readingSpot->offlineBooks()->count(),
            'offline_copies' => $readingSpot->offlineBookCopies()->count(),
            'active_holds'   => $readingSpot->holds()->active()->count(),
            'active_checkouts' => $readingSpot->checkouts()->active()->count(),
        ];
        return view('reading-spots.show', compact('readingSpot', 'stats'));
    }

    public function edit(ReadingSpot $readingSpot)
    {
        return view('reading-spots.edit', ['spot' => $readingSpot]);
    }

    public function update(Request $r, ReadingSpot $readingSpot)
    {
        $data = $r->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:school,library,community,public',
            'npsn'        => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'province'    => 'nullable|string|max:100',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',
            'phone'       => 'nullable|string|max:30',
            'email'       => 'nullable|email',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
            'logo'        => 'nullable|image|max:2048',
        ]);
        if ($r->hasFile('logo')) {
            if ($readingSpot->logo) Storage::disk('public')->delete($readingSpot->logo);
            $data['logo'] = $r->file('logo')->store('reading-spots', 'public');
        }
        $readingSpot->update($data);
        return back()->with('toast', 'Reading Spot diperbarui.');
    }

    public function destroy(ReadingSpot $readingSpot)
    {
        $readingSpot->delete();
        return redirect()->route('reading-spots.index')->with('toast', 'Reading Spot dihapus.');
    }
}
