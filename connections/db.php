<?php

class DBConnection extends PDO
{
    public function __construct($file = 'db.ini')
    {
        if (!$settings = parse_ini_file($file, TRUE)) throw new Exception('Unable to open ' . $file . '.');

        $dns = $settings['database']['driver'] . ':host=' . $settings['database']['host'];
        if (!empty($settings['database']['port'])) {
            $dns .= ';port=' . $settings['database']['port'];
        }
        $dns .= ';dbname=' . $settings['database']['schema'];
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }
}
