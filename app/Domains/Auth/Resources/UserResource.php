<?php
declare(strict_types=1);

namespace App\Domains\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UpdateUserResponse',
    title: "UpdateUserResponse",
    description: "Update User Response",
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
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'age' => $this->resource->age,
        ];
    }
}
