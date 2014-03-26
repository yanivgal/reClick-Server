<?php

namespace reClick\Framework;

use reClick\Framework\Configs\Config;

class Db {

    /**
     * @param string $queryString
     * @param array $values
     * @return mixed
     */
    public function query($queryString, $values = []) {
        $db = $this->connect();

        foreach ($values as $key => $value) {
            $values[':' . $key] = $value;
            unset($values[$key]);
        }

        $statement = $db->prepare($queryString);
        $statement->execute($values);

        return $statement->fetch();
    }

    /**
     * Connect to database
     *
     * @return \PDO
     */
    private function connect() {
        $dbConfig = (new Config())->db();

        try {
            $dbh = new \PDO(
                $dbConfig->driver()
                . ':host=' . $dbConfig->host()
                . ';dbname=' . $dbConfig->dbName(),
                $dbConfig->username(),
                $dbConfig->password()
            );
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        return $dbh;
    }
} 