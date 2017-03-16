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
use Vainyl\Pdo\PdoDatabase;

/**
 * Class PdoDatabaseFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class PdoDatabaseFactory
{
    /**
     * @param PdoConnection $pdoConnection
     *
     * @return PdoDatabase
     */
    public function createDatabase(PdoConnection $pdoConnection): PdoDatabase
    {
        return new PdoDatabase($pdoConnection);
    }
}