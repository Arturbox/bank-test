<?php
declare(strict_types=1);

namespace App\Domains\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TokenResponse',
    title: "TokenResponse",
    description: "Token Response",
    properties: [
        new OA\Property(
            property: 'token',
            title: "token",
            description: "token",
            type: 'string',
            example: "Hp2GTufHe9xgsOYyWMG3LFX2tzX1mrSBFrISJyCTcd6cf831"
        ),
        new OA\Property(
            property: 'token_type',
            title: "token_type",
            description: "token type",
            type: 'string',
            example: "bearer"
        ),
        new OA\Property(
            ref: "#/components/schemas/UpdateUserResponse"
        ),
    ],
)]
class TokenResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $token = $this->resource->createToken('api-token')->plainTextToken;

        return [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($this->resource),
        ];
    }


}
