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

use Vainyl\Connection\AbstractConnection;

/**
 * Class PdoConnection
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class PdoConnection extends AbstractConnection
{
    private $engine;

    private $host;

    private $port;

    private $databaseName;

    private $userName;

    private $password;

    /**
     * PdoConnection constructor.
     *
     * @param string $connectionName
     * @param string string
     * @param string $engine
     * @param string $host
     * @param int    $port
     * @param string $databaseName
     * @param string $userName
     * @param string $password
     * @param array  $options
     */
    public function __construct(
        $connectionName,
        string $host,
        string $engine,
        int $port,
        string $databaseName,
        string $userName,
        string $password,
        array $options
    ) {
        $this->engine = $engine;
        $this->host = $host;
        $this->port = $port;
        $this->databaseName = $databaseName;
        $this->userName = $userName;
        $this->password = $password;
        parent::__construct($connectionName, $options);
    }

    /**
     * @inheritDoc
     */
    public function establish()
    {
        $type = 'pgsql';
        $sslMode = '';
        $dsn = sprintf('%s:host=%s;port=%d;dbname=%s', $type, $this->host, $this->port, $this->databaseName);

        if ('' !== $sslMode) {
            $dsn .= sprintf(';sslmode=%s', $sslMode);
        }

        $options = [
            \PDO::ATTR_EMULATE_PREPARES => true,
            \PDO::ATTR_ERRMODE          => \PDO::ERRMODE_EXCEPTION,
        ];
        $pdo = new \PDO($dsn, $this->userName, $this->password, $options);
        if (defined('PDO::PGSQL_ATTR_DISABLE_PREPARES')
            && (!isset($driverOptions[\PDO::PGSQL_ATTR_DISABLE_PREPARES])
                || true === $driverOptions[\PDO::PGSQL_ATTR_DISABLE_PREPARES]
            )
        ) {
            $pdo->setAttribute(\PDO::PGSQL_ATTR_DISABLE_PREPARES, true);
        }

        return $pdo;
    }
}
