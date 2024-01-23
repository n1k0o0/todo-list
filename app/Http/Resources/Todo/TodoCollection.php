<?php

namespace App\Http\Resources\Todo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    title: 'TodoCollection',
    description: 'TodoCollection',
    properties: [
        new Property(property: 'data', description: 'Data', type: 'array', items: new Items(ref: '#/components/schemas/TodoResource')),
        new Property(property: 'count', description: 'Total count', type: 'integer', example: 150)
    ],
)]
/**
 * @see \App\Models\Todo
 */
class TodoCollection extends ResourceCollection
{
    /**
     * Transform the resource into a JSON array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
