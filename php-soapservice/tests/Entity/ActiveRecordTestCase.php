<?php

namespace Application\Tests;

use Application\config\MysqlDBAdapter;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

abstract class ActiveRecordTestCase extends TestCase
{
    use TestCaseTrait;

    static private $pdo = null;

    private $conn = null;

    final public function getConnection()
    {
        if ($this->conn === null) {
            $adapter = new MysqlDBAdapter(
                $GLOBALS['DB_HOST'],
                $GLOBALS['DB_NAME'],
                $GLOBALS['DB_USER'],
                $GLOBALS['DB_PASSWORD']
            );
            self::$pdo =  $adapter->getConnection();
            $this->conn = $this->createDefaultDBConnection(self::$pdo);
        }

        return $this->conn;
    }
}
