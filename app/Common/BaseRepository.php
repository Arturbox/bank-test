<?php
declare(strict_types=1);

namespace App\Common;

use App\Exceptions\RepositoryException;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class BaseRepository
{
    protected Builder $builder;
    protected Connection $connection;

    public function __construct(Model $model)
    {
        $this->builder = $model->newQuery();
        $this->connection = $model->getConnection();
    }


    public function startTransaction(): void
    {
        try {
            if ($this->connection->transactionLevel() === 0) {
                $this->connection->beginTransaction();
            }
        } catch (Throwable $e) {
            throw new RepositoryException($e->getMessage(), 500, $e);
        }
    }

    public function commitTransaction(): void
    {
        try {
            if ($this->connection->transactionLevel() > 0) {
                $this->connection->commit();
            }
        } catch (Throwable $e) {
            throw new RepositoryException($e->getMessage(), 500, $e);
        }
    }

    public function rollbackTransaction(): void
    {
        try {
            if ($this->connection->transactionLevel() > 0) {
                $this->connection->rollBack();
            }
        } catch (Throwable $e) {
            throw new RepositoryException($e->getMessage(), 500, $e);
        }
    }

}
