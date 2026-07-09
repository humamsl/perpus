<?php

namespace App\Http\Controllers;

use App\Models\AppProfile;
use App\Models\ReadingSpot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppProfileController extends Controller
{
    public function edit(ReadingSpot $readingSpot)
    {
        $profile = AppProfile::firstOrCreate(['reading_spot_id' => $readingSpot->id], ['app_name' => $readingSpot->name]);
        return view('app-profiles.edit', compact('readingSpot', 'profile'));
    }

    public function update(Request $r, ReadingSpot $readingSpot)
    {
        $profile = AppProfile::firstOrCreate(['reading_spot_id' => $readingSpot->id]);
        $data = $r->validate([
            'app_name'        => 'required|string|max:255',
            'primary_color'   => 'nullable|string|max:10',
            'secondary_color' => 'nullable|string|max:10',
            'about'           => 'nullable|string',
            'terms'           => 'nullable|string',
            'privacy_policy'  => 'nullable|string',
            'contact_email'   => 'nullable|email',
            'contact_phone'   => 'nullable|string|max:30',
            'facebook'        => 'nullable|string|max:255',
            'instagram'       => 'nullable|string|max:255',
            'twitter'         => 'nullable|string|max:255',
            'youtube'         => 'nullable|string|max:255',
            'logo'            => 'nullable|image|max:2048',
            'favicon'         => 'nullable|file|max:512',
        ]);
        foreach (['logo','favicon'] as $field) {
            if ($r->hasFile($field)) {
                if ($profile->{$field}) Storage::disk('public')->delete($profile->{$field});
                $data[$field] = $r->file($field)->store('app-profiles', 'public');
            }
        }
        $profile->update($data);
        AppProfile::forgetCache();
        return back()->with('toast', 'Profil aplikasi diperbarui.');
    }
}
