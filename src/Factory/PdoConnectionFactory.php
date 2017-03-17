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
     * @param string $name
     * @param array  $configData
     *
     * @return PdoConnection
     */
    public function createConnection(string $name, array $configData) : PdoConnection
    {
        return new PdoConnection($name, $configData);
    }
}