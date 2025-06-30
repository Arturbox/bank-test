<?php
declare(strict_types=1);

namespace App\Domains\Transfer\Repositories;

use App\Common\BaseRepository;
use App\Domains\Transfer\Models\Transfer;
use App\Exceptions\RepositoryException;
use PDOException;

class TransferRepository extends BaseRepository
{

    public function __construct(Transfer $transfer)
    {
        parent::__construct($transfer);
    }

    public function create(
        int $fromUserId,
        int $toUserId,
        int $fromAccountId,
        int $toAccountId,
        string $amount
    ): Transfer {
        try {
            return $this->builder->create([
                'from_user_id' => $fromUserId,
                'to_user_id' => $toUserId,
                'from_account_id' => $fromAccountId,
                'to_account_id' => $toAccountId,
                'amount' => $amount,
            ]);
        } catch (PDOException $e) {
            throw new RepositoryException($e->getMessage(), 500, $e);
        }
    }

}
