<?php
declare(strict_types=1);

namespace App\Domains\Auth\Requests;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UpdateUserRequest',
    title: "UpdateUserRequest",
    description: "Update User Request",
    required: ['name', 'email', 'age'],
    properties: [
        new OA\Property(
            property: 'name',
            title: "Name",
            description: "Name",
            type: 'string',
            example: "John Doe"
        ),
        new OA\Property(
            property: 'email',
            title: "Email",
            description: "email",
            type: 'string',
            example: "aaa@mail.ru"
        ),
        new OA\Property(
            property: 'age',
            title: "Email",
            description: "email",
            type: 'integer',
            example: 5
        ),
    ],
)]
class UpdateRequest extends Request
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'age' => 'required|int|min:0',
        ];
    }


}
