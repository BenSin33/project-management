<?php
/**
 * Database Configuration
 */
class Database
{
    private static $instance = null;
    private $connection;

    // Database credentials
    private $host = 'localhost';
    private $db_name = 'galaxy_cinema';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';

    private function __construct()
    {
        $this->host = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? $this->host);
        $this->db_name = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? $this->db_name);
        $this->username = getenv('DB_USER') ?: (getenv('DB_USERNAME') ?: ($_ENV['DB_USER'] ?? ($_ENV['DB_USERNAME'] ?? $this->username)));
        $envPassword = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : ($_ENV['DB_PASSWORD'] ?? null);
        if ($envPassword !== null) {
            $this->password = $envPassword;
        }
        $this->charset = getenv('DB_CHARSET') ?: ($_ENV['DB_CHARSET'] ?? $this->charset);

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die(json_encode([
                'success' => false,
                'message' => 'Database Connection Error: ' . $e->getMessage()
            ]));
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    // Prevent cloning
    private function __clone()
    {
    }

    // Prevent unserialization
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}
