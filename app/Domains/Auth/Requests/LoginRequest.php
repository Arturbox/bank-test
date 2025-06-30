<?php
declare(strict_types=1);

namespace App\Domains\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;


#[OA\Schema(
    schema: 'LoginRequest',
    title: "UpdateUserRequest",
    description: "Update User Request",
    required: ['email', 'password'],
    properties: [
        new OA\Property(
            property: 'email',
            title: "Email",
            description: "email",
            type: 'string',
            example: "aaa@mail.ru"
        ),
        new OA\Property(
            property: 'password',
            title: "password",
            description: "password",
            type: 'string',
            example: 'password'
        ),
    ],
)]
class LoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ];
    }


}
