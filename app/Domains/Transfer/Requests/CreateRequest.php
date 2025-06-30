<?php
declare(strict_types=1);

namespace App\Domains\Transfer\Requests;


use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CreateTransferRequest',
    title: "CreateTransferRequest",
    description: "Create Transfer Request",
    required: ['from_account_id', 'to_account_id', 'amount'],
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
            type: 'string',
            example: "1000"
        ),
    ],
)]
class CreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_account_id' => 'required|int|exists:accounts,id',
            'to_account_id' => 'required|int|exists:accounts,id',
            'amount' => 'required|numeric|min:0',
        ];
    }


}
