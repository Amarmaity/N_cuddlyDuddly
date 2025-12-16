<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'slug'      => $this->slug,
            'price'     => $this->price,

            'seller' => [
                'id'   => $this->seller->id ?? null,
                'name' => $this->seller->name ?? null,
            ],

            'images' => $this->images->map(fn ($img) => [
                'image_path' => $img->image_path,
                'is_primary' => $img->is_primary,
            ]),
        ];
    }
}
