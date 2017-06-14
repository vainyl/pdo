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

use Vainyl\Connection\ConnectionInterface;
use Vainyl\Connection\Factory\ConnectionFactoryInterface;
use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Pdo\PdoConnection;

/**
 * Class PdoConnectionFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class PdoConnectionFactory extends AbstractIdentifiable implements ConnectionFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createConnection(
        string $name,
        string $host,
        int $port,
        string $userName,
        string $password,
        array $options
    ): ConnectionInterface {
        return new PdoConnection($name, $host, $port, $userName, $password, $options);
    }
}
