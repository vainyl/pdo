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

use Vainyl\Pdo\PdoDatabase;

/**
 * Class PdoDatabaseFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class PdoDatabaseFactory
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
     * @param string $name
     * @param array  $configData
     *
     * @return PdoDatabase
     */
    public function createDatabase(string $name, array $configData): PdoDatabase
    {
        return new PdoDatabase($name, $this->connectionStorage[$configData['connection']]);
    }
}
