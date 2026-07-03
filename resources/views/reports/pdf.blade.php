<!doctype html>
<html><head><meta charset="utf-8"><title>{{ $title }}</title>
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; padding: 24px; color: #1a1a1a; font-size: 12px; }
    h1 { font-size: 18px; margin: 0 0 4px 0; color: #4c1d95; }
    p { margin: 0 0 16px 0; color: #555555; font-size: 11px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #dddddd; padding: 8px; font-size: 11px; text-align: left; }
    thead th { background-color: #f3f3f6; color: #333333; font-weight: bold; }
    tbody tr:nth-child(even) { background-color: #fafafa; }
</style>
</head><body>
<h1>{{ $title }}</h1>
<p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
<table><thead><tr><th>#</th><th>Detail</th><th>Info</th></tr></thead><tbody>
@foreach($rows as $i => $r)
<tr><td>{{ $i+1 }}</td><td>{{ $r->title ?? $r->book?->title }}</td><td>{{ $r->borrow_count ?? ($r->due_at?->format('d M Y') ?? '') }}</td></tr>
@endforeach
</tbody></table>
</body></html>
