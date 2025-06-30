<?php
declare(strict_types=1);

namespace App\Domains\Transfer\Repositories;

use App\Common\BaseRepository;
use App\Domains\Transfer\Models\Account;
use App\Exceptions\RepositoryException;
use PDOException;

class AccountRepository extends BaseRepository
{

    public function __construct(Account $account)
    {
        parent::__construct($account);
    }

    /**
     * @return array<int, Account>
     */
    public function findManyByIds(array $ids): array
    {
        try {
            return $this->builder->whereIn('id', $ids)
                ->orderByRaw('array_position(ARRAY[' . implode(',', $ids) . '], id)')
                ->get()->all();
        } catch (PDOException $e) {
            throw new RepositoryException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function update(Account $account): void
    {
        try {
            $account->update();
        } catch (PDOException $e) {
            throw new RepositoryException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function updateBalance(Account $account, string $amount): void
    {
        $account->balance = $amount;

        $this->update($account);
    }

}
