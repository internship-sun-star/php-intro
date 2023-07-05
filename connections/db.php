<?php

class DBConnection extends PDO
{
    private static $instance = null;

    private function __construct($file = 'db.ini')
    {
        if (!$settings = parse_ini_file($file, TRUE)) throw new Exception('Unable to open ' . $file . '.');

        $dns = $settings['database']['driver'] . ':host=' . $settings['database']['host'];
        if (!empty($settings['database']['port'])) {
            $dns .= ';port=' . $settings['database']['port'];
        }
        $dns .= ';dbname=' . $settings['database']['schema'];
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): DBConnection
    {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new DBConnection();
                self::$instance->exec("SET NAMES 'utf8'");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        return self::$instance;
    }
}
