<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'isbn'         => $this->isbn,
            'title'        => $this->title,
            'subtitle'     => $this->subtitle,
            'cover_url'    => $this->cover ? asset('storage/'.$this->cover) : null,
            'synopsis'     => $this->synopsis,
            'language'     => $this->language,
            'year'         => $this->year_published,
            'pages'        => $this->pages,
            'status'       => $this->status,
            'rating'       => (float) $this->rating_avg,
            'rating_count' => $this->rating_count,
            'category'     => $this->whenLoaded('category',  fn () => $this->category?->name),
            'publisher'    => $this->whenLoaded('publisher', fn () => $this->publisher?->name),
            'authors'      => $this->whenLoaded('authors',   fn () => $this->authors->pluck('name')),
        ];
    }
}
