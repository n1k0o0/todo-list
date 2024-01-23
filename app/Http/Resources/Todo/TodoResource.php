<?php

namespace App\Http\Resources\Todo;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    title: 'TodoResource',
    description: 'TodoResource',
    properties: [
        new Property(property: 'id', description: 'Id', type: 'integer', example: 150),
        new Property(property: 'name', description: 'name', type: 'string', example: 'first'),
        new Property(property: 'is_done', description: 'Is done', type: 'boolean', example: true),
    ],
)]
/**
 * @mixin Todo
 */
class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_done' => $this->is_done
        ];
    }
}
