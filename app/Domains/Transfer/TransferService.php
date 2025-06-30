<?php
declare(strict_types=1);

namespace App\Domains\Transfer;

use App\Domains\Transfer\Calculation\Calculator;
use App\Domains\Transfer\Calculation\Strategy\AddAmountToAccountStrategy;
use App\Domains\Transfer\Calculation\Strategy\SubAmountToAccountStrategy;
use App\Domains\Transfer\Dto\CreateTransferDto;
use App\Domains\Transfer\Repositories\AccountRepository;
use App\Domains\Transfer\Repositories\TransferRepository;
use App\Domains\Transfer\Models\Account;
use App\Domains\Transfer\Models\Transfer;
use App\Exceptions\RepositoryException;
use App\Exceptions\ServiceException;
use Throwable;

readonly class TransferService
{

    public function __construct(
        private Calculator $calculator,
        private TransferRepository $transferRepository,
        private AccountRepository $accountRepository,
    ) {
    }


    public function create(CreateTransferDto $dto): Transfer
    {
        try {
            [$fromAccount, $toAccount] = $this->accountRepository->findManyByIds([
                $dto->getFromAccountId(),
                $dto->getToAccountId(),
            ]);

            $fromAccountBalance = $this->subBalance($fromAccount, $dto->getAmount());
            if ((int)$fromAccountBalance < 0) {
                throw new ServiceException('Not enough funds to transfer');
            }

            $toAccountBalance = $this->addBalance($toAccount, $dto->getAmount());

            $this->transferRepository->startTransaction();

            $this->accountRepository->updateBalance($fromAccount, $fromAccountBalance);

            $this->accountRepository->updateBalance($toAccount, $toAccountBalance);

            $transfer = $this->transferRepository->create(
                $fromAccount->user_id,
                $toAccount->user_id,
                $fromAccount->id,
                $toAccount->id,
                $dto->getAmount()
            );

            $this->transferRepository->commitTransaction();

            return $transfer;

        } catch (RepositoryException $e) {
            $this->transferRepository->rollbackTransaction();
            throw $e;
        } catch (Throwable $e) {
            throw new ServiceException($e->getMessage(), $e->getCode(), $e);
        }
    }


    private function addBalance(Account $account, string $amount): string
    {
        $this->calculator->strategy = new AddAmountToAccountStrategy();

        return $this->calculator->calculate($account, $amount);
    }

    private function subBalance(Account $account, string $amount): string
    {

        $this->calculator->strategy = new SubAmountToAccountStrategy();

        return $this->calculator->calculate($account, $amount);
    }


}
