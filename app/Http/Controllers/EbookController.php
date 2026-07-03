<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\EbookBookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index(Request $r)
    {
        $items = Ebook::with('book')
            ->when($r->format, fn($q) => $q->where('format', $r->format))
            ->when($r->q,      fn($q) => $q->where('title', 'like', "%{$r->q}%"))
            ->latest()->paginate(20);
        return view('ebooks.index', compact('items'));
    }

    public function read(Ebook $ebook)
    {
        abort_unless($this->canAccess($ebook), 403);
        $ebook->increment('view_count');
        $bookmark = EbookBookmark::firstOrCreate(
            ['user_id' => auth()->id(), 'ebook_id' => $ebook->id],
            ['page' => 1]
        );
        return view('ebooks.read', compact('ebook', 'bookmark'));
    }

    public function bookmark(Request $r, Ebook $ebook)
    {
        $data = $r->validate([
            'page' => 'required|integer|min:1',
            'note' => 'nullable|string|max:200',
        ]);
        EbookBookmark::updateOrCreate(
            ['user_id' => auth()->id(), 'ebook_id' => $ebook->id],
            $data
        );
        return response()->json(['ok' => true]);
    }

    public function download(Ebook $ebook)
    {
        abort_unless($ebook->downloadable && $this->canAccess($ebook), 403);
        $ebook->increment('download_count');
        return Storage::disk('public')->download($ebook->file_path);
    }

    public function track(Request $r, Ebook $ebook)
    {
        return response()->json(['ok' => true]);
    }

    public function manage(Request $r) { return $this->index($r); }
    public function create() { return view('ebooks.create'); }
    public function store(Request $r) {
        $data = $r->validate([
            'title'  => 'required|string|max:255',
            'format' => 'required|in:pdf,epub,docx,pptx,audio,video',
            'file'   => 'required|file|max:51200',
            'access' => 'required|in:public,member,staff',
            'downloadable' => 'boolean',
        ]);
        $path = $r->file('file')->store('ebooks', 'public');
        Ebook::create([
            'title'        => $data['title'],
            'format'       => $data['format'],
            'access'       => $data['access'],
            'file_path'    => $path,
            'file_size'    => $r->file('file')->getSize(),
            'downloadable' => $r->boolean('downloadable'),
        ]);
        return redirect()->route('ebooks.index')->with('toast', 'E-Book diunggah.');
    }
    public function edit(Ebook $ebook)   { return view('ebooks.edit', compact('ebook')); }
    public function update(Request $r, Ebook $ebook) {
        $ebook->update($r->only(['title','format','access','downloadable']));
        return back()->with('toast', 'E-Book diperbarui.');
    }
    public function destroy(Ebook $ebook) {
        $ebook->delete();
        return back()->with('toast', 'E-Book dihapus.');
    }

    protected function canAccess(Ebook $e): bool
    {
        $u = auth()->user();
        // Petugas/admin perpustakaan dapat mengakses seluruh koleksi.
        if ($u?->hasAnyRole(['staff', 'admin', 'super_admin'])) {
            return true;
        }
        return match ($e->access) {
            'public' => true,
            'member' => (bool) ($u?->member),
            'staff'  => false,
        };
    }
}
