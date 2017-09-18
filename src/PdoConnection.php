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

    private $options;

    /**
     * PdoConnection constructor.
     *
     * @param string $connectionName
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
        string $engine,
        string $host,
        int $port,
        string $databaseName,
        string $userName,
        string $password,
        array $options
    ) {
        $this->engine       = $engine;
        $this->host         = $host;
        $this->port         = $port;
        $this->databaseName = $databaseName;
        $this->userName     = $userName;
        $this->password     = $password;
        $this->options      = $options;
        parent::__construct($connectionName);
    }

    /**
     * @inheritDoc
     */
    public function doEstablish()
    {
        $sslMode = array_key_exists('sslmode', $this->options)
            ? $this->options['sslmode']
            : '';
        $charset = array_key_exists('charset', $this->options)
            ? $this->options['charset']
            : '';

        $dsn = sprintf('%s:host=%s;port=%d;dbname=%s', $this->engine, $this->host, $this->port, $this->databaseName);

        if ('' !== $sslMode) {
            $dsn .= sprintf(';sslmode=%s', $sslMode);
        }

        if ('' !== $charset) {
            $dsn .= sprintf(';charset=%s', $charset);
        }

        $options = [
            \PDO::ATTR_EMULATE_PREPARES => true,
            \PDO::ATTR_ERRMODE          => \PDO::ERRMODE_EXCEPTION,
        ];
        $pdo     = new \PDO($dsn, $this->userName, $this->password, $options);
        if (defined('PDO::PGSQL_ATTR_DISABLE_PREPARES')
            && (!isset($options[\PDO::PGSQL_ATTR_DISABLE_PREPARES])
                || true === $options[\PDO::PGSQL_ATTR_DISABLE_PREPARES]
            )
        ) {
            $pdo->setAttribute(\PDO::PGSQL_ATTR_DISABLE_PREPARES, true);
        }

        return $pdo;
    }
}
