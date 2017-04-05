<?php
/**
 * Vainyl
 *
 * PHP Version 7
 *
 * @package   pdo
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://vainyl.com
 */
declare(strict_types=1);

namespace Vainyl\Pdo;

use Vainyl\Database\CursorInterface;

/**
 * Class PdoCursor
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class PdoCursor implements CursorInterface
{
    private $pdoStatementInstance;

    private $mode;

    private $position = 0;

    /**
     * VainDatabasePDOGenerator constructor.
     *
     * @param \PDOStatement $pdoStatementInstance
     * @param int           $mode
     */
    public function __construct(\PDOStatement $pdoStatementInstance, $mode = \PDO::FETCH_ASSOC)
    {
        $this->pdoStatementInstance = $pdoStatementInstance;
        $this->mode = $mode;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function current(): array
    {
        return $this->pdoStatementInstance->fetch($this->mode, \PDO::FETCH_ORI_ABS, $this->position);
    }

    /**
     * @inheritDoc
     */
    public function next(): bool
    {
        $this->position++;

        return $this->pdoStatementInstance->nextRowset();
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return ($this->pdoStatementInstance->errorCode() === '00000');
    }

    /**
     * @inheritDoc
     */
    public function close(): CursorInterface
    {
        $this->pdoStatementInstance->closeCursor();

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mode(int $mode): CursorInterface
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->pdoStatementInstance->rowCount();
    }

    /**
     * @inheritDoc
     */
    public function getSingle(): array
    {
        $this->position++;

        return $this->pdoStatementInstance->fetch($this->mode);
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $this->position = $this->pdoStatementInstance->rowCount();

        return $this->pdoStatementInstance->fetchAll($this->mode);
    }
}
