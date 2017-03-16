<?php
/**
 * Vain Framework
 *
 * PHP Version 7
 *
 * @package   pdo
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://vainyl.com
 */
declare(strict_types = 1);
namespace Vainyl\Pdo;

use Vainyl\Database\AbstractMvccDatabase;
use Vainyl\Database\CursorInterface;
use Vainyl\Pdo\Exception\QueryPdoDatabaseException;
use Vainyl\Pdo\Exception\TransactionPdoDatabaseException;

/**
 * Class PDOAdapter
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 *
 * @method \PDO getConnection
 */
class PdoDatabase extends AbstractMvccDatabase
{
    /**
     * @inheritDoc
     */
    public function doStartTransaction(): bool
    {
        try {
            return $this->getConnection()->beginTransaction();
        } catch (\PDOException $exception) {
            throw new TransactionPdoDatabaseException(
                $this,
                'start',
                (string)$exception->getCode(),
                $exception->errorInfo
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function doCommitTransaction(): bool
    {
        try {
            return $this->getConnection()->commit();
        } catch (\PDOException $exception) {
            throw new TransactionPdoDatabaseException(
                $this,
                'commit',
                (string)$exception->getCode(),
                $exception->errorInfo
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function doRollbackTransaction(): bool
    {
        try {
            return $this->getConnection()->rollBack();
        } catch (\PDOException $exception) {
            throw new TransactionPdoDatabaseException(
                $this,
                'rollback',
                (string)$exception->getCode(),
                $exception->errorInfo
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function runQuery($query, array $bindParams, array $bindParamTypes = []): CursorInterface
    {
        try {
            $statement = $this->getConnection()->prepare($query);
            if (false == $statement->execute($bindParams)) {
                throw new QueryPdoDatabaseException(
                    $this,
                    $query,
                    $bindParams,
                    $statement->errorCode(),
                    $statement->errorInfo()
                );
            }
        } catch (\PDOException $exception) {
            throw new QueryPdoDatabaseException(
                $this,
                $query,
                $bindParams,
                (string)$exception->getCode(),
                $exception->errorInfo
            );
        }

        return new PDOCursor($statement);
    }
}
