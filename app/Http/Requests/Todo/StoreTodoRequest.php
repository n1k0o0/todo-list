<?php

namespace App\Http\Requests\Todo;

use App\DTO\Todo\TodoDTO;
use App\Traits\ToDTOTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

#[RequestBody(
    request: 'StoreTodoRequest',
    required: true,
    content: new JsonContent(
        properties: [
            new Property(property: 'name', description: 'Name', type: 'string', example: 'name'),
        ]
    )
)]
class StoreTodoRequest extends FormRequest
{
    use ToDTOTrait;

    private string $dtoClass = TodoDTO::class;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255']
        ];
    }
}
