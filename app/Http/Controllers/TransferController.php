<?php
declare(strict_types=1);

namespace App\Http\Controllers;


use App\Domains\Transfer\Dto\CreateTransferDto;
use App\Domains\Transfer\Requests\CreateRequest;
use App\Domains\Transfer\Resources\TransferResource;
use App\Domains\Transfer\TransferService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class TransferController extends Controller
{
    public function __construct(private readonly TransferService $transferService)
    {

    }


    #[OA\Post(path: '/transfer/update', description: 'Create transfer')]
    #[OA\Parameter(name: 'Authorization', in: 'header', required: true, schema: new OA\Schema(
        type: "string"
    ), example: 1234)]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: "#/components/schemas/CreateTransferRequest",
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Create transfer',
        content: new OA\JsonContent(
            ref: "#/components/schemas/TransferResponse",
        )
    )]
    public function create(CreateRequest $request): JsonResponse
    {
        $createDto = new CreateTransferDto($request);

        $transfer = $this->transferService->create($createDto);

        return new TransferResource($transfer)->toResponse($request);
    }


}
