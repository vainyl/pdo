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

namespace Vainyl\Pdo\Exception;

use Vainyl\Database\Exception\AbstractDatabaseException;
use Vainyl\Pdo\PdoDatabase;

/**
 * Class AbstractPdoDatabaseException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class AbstractPdoDatabaseException extends AbstractDatabaseException
{
    private $errorCode;

    private $errorInfo;

    /**
     * AbstractPdoDatabaseException constructor.
     *
     * @param PdoDatabase     $database
     * @param string          $errorCode
     * @param array           $errorInfo
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(
        PdoDatabase $database,
        string $errorCode,
        array $errorInfo,
        string $message = '',
        int $code = 500,
        \Throwable $previous = null
    ) {
        $this->errorCode = $errorCode;
        $this->errorInfo = $errorInfo;
        parent::__construct($database, $message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(
            [
                'error_code' => $this->errorCode,
                'error_info' => $this->errorInfo,
            ],
            parent::toArray()
        );
    }
}
