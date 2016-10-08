<?php

namespace Core\Providers;

use PDO;

class PdoServiceProvider extends ServiceProvider
{
    public function provide(array $options = [])
    {
        $dbh = new PDO('mysql:dbname='.$this->config['dbname'].';host='.$this->config['host'].'', $this->config['user'], $this->config['password'] );
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $dbh;
    }
}