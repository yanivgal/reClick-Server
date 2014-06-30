<?php

namespace reClick\Framework;

use reClick\Framework\Configs\Config;

class Db {

    /**
     * @var \PDOStatement
     */
    private $statement;

    /**
     * Executes raw SQL statement
     *
     * @param string $statement
     */
    public function exec($statement) {
        $db = $this->connect();

        $db->exec($statement);
    }

    /**
     * Executes an SQL statement created with raw query string from $queryString
     * and with bound values from $values array
     *
     * @param string $queryString
     * @param array $values
     * @return Db|mixed
     */
    public function query($queryString, $values = []) {
        $db = $this->connect();

        $this->statement = $db->prepare($queryString);
        $this->bindValues($values);
        $this->statement->execute();

        return $this;
    }

    /**
     * Builds a Select query using passed variables
     *
     * @param string $table
     * @param array $columns
     * @param array $where
     * @param string $groupBy
     * @param string $having
     * @param string $orderBy
     * @param string $limit
     * @param bool $distinct
     * @return Db
     */
    public function select(
        $table,
        $columns,
        $where,
        $groupBy = null,
        $having = null,
        $orderBy = null,
        $limit = null,
        $distinct = false
    ) {
        $db = $this->connect();

        $queryString = 'SELECT ';

        if ($distinct) {
            $queryString .= 'DISTINCT ';
        }

        $queryString .= $this->toCommaString($columns) . ' ';

        $queryString .= 'FROM ' . $table . ' ' . $this->toWhereClause($where);

        if (isset($groupBy)) {
            $queryString .= ' GROUP BY ' . $groupBy;
        }

        if (isset($having)) {
            $queryString .= ' HAVING ' . $having;
        }

        if (isset($orderBy)) {
            $queryString .= ' ORDER BY ' . $orderBy;
        }

        if (isset($limit)) {
            $queryString .= ' LIMIT ' . $limit;
        }

        $this->statement = $db->prepare($queryString);
        $this->bindValues($where);
        $this->statement->execute();

        return $this;
    }

    /**
     * Builds and executes an Insert query using passed variables
     *
     * @param string $table
     * @param array $values [col1 => val1, col2 => val2, ... ]
     * @return int last insert id
     */
    public function insert($table, $values) {
        $db = $this->connect();

        $columns = $this->toCommaString(array_keys($values));

        $queryString = 'INSERT INTO ' . $table
            . ' (' . $columns . ')'
            . ' VALUES '
            . '('
            . $this->toCommaString($this->valuesToQuestionMark($values))
            . ')';

        $this->statement = $db->prepare($queryString);
        $this->bindValues($values);
        $this->statement->execute();

        return $db->lastInsertId();
    }

    /**
     * Builds and executes an Update query using passed variables
     *
     * @param string $table
     * @param array $values
     * @param array $where
     * @return int number of effected rows
     */
    public function update($table, $values, $where) {
        $db = $this->connect();

        $queryString = 'UPDATE ' . $table. ' '
            . $this->toSetClause($values) . ' '
            . $this->toWhereClause($where);

        $this->statement = $db->prepare($queryString);
        $this->bindValues(array_merge($values, $where));
        $this->statement->execute();

        return $this->statement->rowCount();
    }

    /**
     * Builds and executes a Delete query using passed variables
     *
     * @param string $table
     * @param array $where
     * @return int number of effected rows
     */
    public function delete($table, $where) {
        $db = $this->connect();

        $queryString = 'DELETE FROM ' . $table . ' '
            . $this->toWhereClause($where);

        $this->statement = $db->prepare($queryString);
        $this->bindValues($where);
        $this->statement->execute();

        return $this->statement->rowCount();
    }

    /**
     * Fetches the db statement and returns first row as an associative array
     * which 'key' is the column name and 'value' is the column value.<p>
     * This method works best with a single row result.
     *
     * @return array
     */
    public function fetchAssoc() {
        $res = $this->statement->fetch();

        if (!empty($res)) {
            foreach ($res as $name => $val) {
                if (is_numeric($name)) {
                    unset($res[$name]);
                }
            }
        }


        return $res;
    }

    /**
     * Fetches the db statement and returns all rows as an array
     *
     * @return array
     */
    public function fetchAll() {
        $res = $this->statement->fetchAll();

        foreach ($res as $rowName => $row) {
            foreach ($row as $col => $val) {
                if (is_numeric($col)) {
                    unset($res[$rowName][$col]);
                }
            }
        }

        return $res;
    }

    /**
     * Fetches the db statement and returns all rows as an associative array
     * which each 'key' is the value of the first column of the respected row
     *
     * @return array
     */
    public function fetchAllAssoc() {
        $res = $this->statement->fetchAll();

        foreach ($res as $rowName => $row) {
            $firstVal = '';
            foreach ($row as $col => $val) {
                if ($val = $row[0]) {
                    $firstVal = $val;
                }
                if (is_numeric($col)) {
                    unset($res[$rowName][$col]);
                }
            }
            $res[$firstVal] = $res[$rowName];
            unset($res[$rowName]);
        }

        return $res;
    }

    /**
     * Fetches the db statement and returns one value which is the first row,
     * first column cell value
     *
     * @return string
     */
    public function fetchValue() {
        return $this->statement->fetchColumn();
    }

    /**
     * Returns the prepared query string
     *
     * @return string
     */
    public function getQueryString() {
        return $this->statement->queryString;
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
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            //TODO Print errors to log
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        return $dbh;
    }

    public function createTestDb() {
        $dbConfig = (new Config())->db();

        try {
            $dbh = new \PDO(
                $dbConfig->driver() . ':host=' . $dbConfig->host(),
                $dbConfig->username(),
                $dbConfig->password()
            );

            $dbh->exec('CREATE DATABASE IF NOT EXISTS ' . $dbConfig->dbName())
            or die(print_r($dbh->errorInfo(), true));
        } catch (\PDOException $e) {
            //TODO Print errors to log
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function dropTestDb() {
        $dbConfig = (new Config())->db();

        try {
            $dbh = new \PDO(
                $dbConfig->driver() . ':host=' . $dbConfig->host(),
                $dbConfig->username(),
                $dbConfig->password()
            );

            $dbh->exec('DROP DATABASE IF EXISTS ' . $dbConfig->dbName());
//            or die(print_r($dbh->errorInfo(), true));
        } catch (\PDOException $e) {
            //TODO Print errors to log
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * Converts array values into string with separating commas.
     * [key1 => val1, key2 => val2, key3 => val3]
     * into
     * 'val1,val2,val3'
     *
     * @param $array
     * @return string
     */
    private function toCommaString($array) {
        return implode(',', $array);
    }

    /**
     * Converts a $where array into SQL WHERE clause
     *
     * @param array $where
     * @return string
     */
    private function toWhereClause($where) {
        return $this->createQueryClause($where, 'WHERE');
    }

    /**
     * Converts a $set array into SQL SET clause
     *
     * @param array $set
     * @return string
     */
    private function toSetClause($set) {
        return $this->createQueryClause($set, 'SET');
    }

    /**
     * Converts array into SQL clause per $clauseType
     *
     * @param array $array
     * @param string $clauseType WHERE|SET
     * @return string
     */
    private function createQueryClause($array, $clauseType) {
        if (empty($array)) {
            return '';
        }

        switch ($clauseType) {
            case 'WHERE':
                $divider = ' AND ';
                break;
            case 'SET':
                $divider = ', ';
                break;
            default:
                return '';
        }

        $clause = $clauseType . ' ';

        foreach ($array as $col => $value) {
            $clause .= $col . ' = ?' . $divider;
        }

        $clause = substr($clause, 0, -1 * strlen($divider));

        return $clause;
    }

    /**
     * Converts all values in given array to '?'
     *
     * @param array $array
     * @return array
     */
    private function valuesToQuestionMark($array) {
        return array_map(function() { return '?'; }, $array);
    }

    /**
     * Binds values to statement
     *
     * @param $array
     */
    private function bindValues($array) {
        $array = array_values($array);
        foreach ($array as $key => $value) {
            $this->statement->bindValue($key + 1, $value);
        }
    }
} 