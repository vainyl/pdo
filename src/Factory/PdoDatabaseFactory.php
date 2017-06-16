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

namespace Vainyl\Pdo\Factory;

use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Database\DatabaseInterface;
use Vainyl\Database\Factory\DatabaseFactoryInterface;
use Vainyl\Pdo\PdoDatabase;

/**
 * Class PdoDatabaseFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class PdoDatabaseFactory extends AbstractIdentifiable implements DatabaseFactoryInterface
{
    private $connectionStorage;

    /**
     * PdoDatabaseFactory constructor.
     *
     * @param \ArrayAccess $connectionStorage
     */
    public function __construct(\ArrayAccess $connectionStorage)
    {
        $this->connectionStorage = $connectionStorage;
    }

    /**
     * @inheritDoc
     */
    public function createDatabase(
        string $databaseName,
        string $connectionName,
        array $options = []
    ): DatabaseInterface {
        return new PdoDatabase($databaseName, $this->connectionStorage[$connectionName]);
    }
}
