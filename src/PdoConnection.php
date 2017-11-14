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
 * @author Andrii Dembitskiy <andrew.dembitskiy@gmail.com>
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
        $options = [
            \PDO::ATTR_EMULATE_PREPARES => true,
            \PDO::ATTR_ERRMODE          => \PDO::ERRMODE_EXCEPTION,
        ];

        $pdo = new \PDO($this->getDsn(), $this->userName, $this->password, $options);

        if (defined('PDO::PGSQL_ATTR_DISABLE_PREPARES')
            && (!isset($options[\PDO::PGSQL_ATTR_DISABLE_PREPARES])
                || true === $options[\PDO::PGSQL_ATTR_DISABLE_PREPARES]
            )
        ) {
            $pdo->setAttribute(\PDO::PGSQL_ATTR_DISABLE_PREPARES, true);
        }

        return $pdo;
    }

    /**
     * @return string
     */
    protected function getDsn(): string
    {
        $dsn = sprintf('%s:host=%s;port=%d;dbname=%s', $this->engine, $this->host, $this->port, $this->databaseName);

        if ('' !== ($sslmode = $this->getSslMode())) {
            $dsn .= sprintf(';sslmode=%s', $sslmode);
        }

        if ('' !== ($charset = $this->getCharset())) {
            $dsn .= sprintf(';charset=%s', $charset);
        }

        return $dsn;
    }

    /**
     * @return string
     */
    protected function getSslMode(): string
    {
        if (array_key_exists('sslmode', $this->options)) {
            return $this->options['sslmode'];
        }

        return '';
    }

    /**
     * @return string
     */
    protected function getCharset(): string
    {
        if (array_key_exists('charset', $this->options)) {
            return $this->options['charset'];
        }

        return '';
    }
}
