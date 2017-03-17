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

use Vainyl\Pdo\PdoDatabase;

/**
 * Class QueryPdoDatabaseException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class QueryPdoDatabaseException extends AbstractPdoDatabaseException
{
    private $query;

    private $bindParams;

    /**
     * QueryPdoDatabaseException constructor.
     *
     * @param PdoDatabase $database
     * @param string      $query
     * @param array       $bindParams
     * @param string      $errorCode
     * @param array       $errorInfo
     */
    public function __construct(
        PdoDatabase $database,
        string $query,
        array $bindParams,
        string $errorCode,
        array $errorInfo
    ) {
        $this->query = $query;
        $this->bindParams = $bindParams;
        parent::__construct(
            $database,
            $errorCode,
            $errorInfo,
            sprintf(
                'Cannot execute query %s with parameters %s in database %s',
                $query,
                implode(', ', $bindParams),
                $database->getName()
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(
            [
                'query'       => $this->query,
                'bind_params' => $this->bindParams,
            ],
            parent::toArray()
        );
    }
}
