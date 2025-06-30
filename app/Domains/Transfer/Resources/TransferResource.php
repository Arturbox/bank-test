<?php
declare(strict_types=1);

namespace App\Domains\Transfer\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TransferResponse',
    title: "TransferResponse",
    description: "Transfer Response",
    properties: [
        new OA\Property(
            property: 'from_account_id',
            title: "from_account_id",
            description: "from_account_id",
            type: 'integer',
            example: 1
        ),
        new OA\Property(
            property: 'to_account_id',
            title: "to_account_id",
            description: "to_account_id",
            type: 'integer',
            example: 2
        ),
        new OA\Property(
            property: 'amount',
            title: "amount",
            description: "amount",
            type: 'integer',
            example: 100
        ),
    ],
)]
class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'from_account_id' => $this->resource->from_account_id,
            'to_account_id' => $this->resource->to_account_id,
            'amount' => $this->resource->amount,
        ];
    }
}
