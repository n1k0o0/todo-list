<?php

namespace App\Http\Requests\Todo;

use App\DTO\Todo\TodoDTO;
use App\Models\Todo;
use App\Traits\ToDTOTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

#[RequestBody(
    request: 'UpdateTodoRequest',
    required: true,
    content: new JsonContent(
        properties: [
            new Property(property: 'name', description: 'Name', type: 'string', example: 'name'),
            new Property(property: 'is_done', description: 'Is done', type: 'boolean', example: true),
        ]
    )
)]
/**
 * @property-read Todo $todo
 * */
class UpdateTodoRequest extends FormRequest
{
    use ToDTOTrait;

    private string $dtoClass = TodoDTO::class;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('users')->id() === $this->todo->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'is_done' => ['nullable', 'boolean'],
        ];
    }
}
