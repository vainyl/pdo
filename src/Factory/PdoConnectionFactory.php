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

namespace Vainyl\Pdo\Factory;

use Vainyl\Pdo\PdoConnection;

/**
 * Class PdoConnectionFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class PdoConnectionFactory
{
    /**
     * @param string $connectionName
     * @param array  $configData
     *
     * @return PdoConnection
     */
    public function createConnection(string $connectionName, array $configData) : PdoConnection
    {
        return new PdoConnection($connectionName, $configData);
    }
}