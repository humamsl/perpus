<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Publisher;
use App\Models\Shelf;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected $model = Book::class;
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 6));
        return [
            'isbn'             => $this->faker->unique()->isbn13(),
            'title'            => rtrim($title, '.'),
            'subtitle'         => $this->faker->optional()->sentence(4),
            'publisher_id'     => Publisher::inRandomOrder()->value('id'),
            'book_category_id' => BookCategory::inRandomOrder()->value('id'),
            'shelf_id'         => Shelf::inRandomOrder()->value('id'),
            'year_published'   => $this->faker->numberBetween(2010, (int) date('Y')),
            'edition'          => 'Pertama',
            'language'         => 'id',
            'pages'            => $this->faker->numberBetween(80, 600),
            'synopsis'         => $this->faker->paragraph(4),
            'keywords'         => implode(',', $this->faker->words(5)),
            'status'           => 'available',
            'barcode'          => 'BK' . Str::upper(Str::random(8)),
            'qr_code'          => 'QR-' . Str::random(10),
        ];
    }
}
