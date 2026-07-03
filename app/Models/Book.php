<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'isbn', 'title', 'subtitle', 'publisher_id', 'book_category_id', 'shelf_id',
        'reading_spot_id', 'ddc_category_id',
        'year_published', 'edition', 'language', 'pages', 'cover', 'images', 'synopsis',
        'keywords', 'status', 'stock', 'available', 'barcode', 'qr_code', 'location',
        'view_count', 'borrow_count', 'rating_avg', 'rating_count',
    ];

    protected $casts = [
        'images'     => 'array',
        'rating_avg' => 'float',
    ];

    public function category()    { return $this->belongsTo(BookCategory::class, 'book_category_id'); }
    public function ddcCategory() { return $this->belongsTo(DdcCategory::class); }
    public function publisher()   { return $this->belongsTo(Publisher::class); }
    public function shelf()       { return $this->belongsTo(Shelf::class); }
    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }
    public function authors()     { return $this->belongsToMany(Author::class, 'book_author'); }
    public function ebooks()      { return $this->hasMany(Ebook::class); }
    public function borrows()     { return $this->hasMany(BorrowTransaction::class); }
    public function reservations(){ return $this->hasMany(Reservation::class); }
    public function reviews()     { return $this->hasMany(Review::class)->where('is_hidden', false); }
    public function wishedBy()    { return $this->belongsToMany(User::class, 'wishlists')->withPivot('created_at'); }

    public function scopeAvailable($q) { return $q->where('available', '>', 0); }

    public function scopeSearch($q, ?string $term)
    {
        return $term
            ? $q->where(fn($w) => $w->where('title', 'like', "%{$term}%")
                                    ->orWhere('isbn', 'like', "%{$term}%")
                                    ->orWhere('keywords', 'like', "%{$term}%"))
            : $q;
    }

    public function recalcRating(): void
    {
        $avg = (float) $this->reviews()->avg('rating');
        $cnt = (int)   $this->reviews()->count();
        $this->forceFill(['rating_avg' => round($avg, 2), 'rating_count' => $cnt])->save();
    }
}
