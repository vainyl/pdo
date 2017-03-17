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
declare(strict_types = 1);

namespace Vainyl\Pdo\Exception;

use Vainyl\Database\Exception\AbstractDatabaseException;
use Vainyl\Pdo\PdoDatabase;

/**
 * Class TransactionPdoDatabaseException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TransactionPdoDatabaseException extends AbstractDatabaseException
{
    private $action;

    private $errorCode;

    private $errorInfo;

    /**
     * TransactionPdoDatabaseException constructor.
     *
     * @param PdoDatabase $database
     * @param string      $action
     * @param string      $errorCode
     * @param array       $errorInfo
     */
    public function __construct(
        PdoDatabase $database,
        string $action,
        string $errorCode,
        array $errorInfo
    ) {
        $this->action = $action;
        $this->errorCode = $errorCode;
        $this->errorInfo = $errorInfo;
        parent::__construct(
            $database,
            sprintf('Unable to %s transaction in database %s', $action, $database->getName())
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['action' => $this->action,], parent::toArray());
    }
}