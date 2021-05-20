<?php

namespace Application\Entity;

date_default_timezone_set('UTC');

use JsonSerializable;
use DateTime;
use PDO;

use Application\config\MysqlDBAdapter;
use Application\Exception\NotImplementedException;
use Application\Exception\ActiveRecordException;
use Application\Exception\RecordNotFoundException;

class ActiveRecord implements JsonSerializable
{
    const TABLE_NAME = 'undefined';

    public ?int $id;

    public DateTime $created_at;

    public DateTime $updated_at;

    private $database;

    public static $db_conn = null;

    public function __construct($db_conn = null)
    {
        $this->id = null;
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
        $this->database = $db_conn ?? ActiveRecord::$db_conn ?? new MysqlDBAdapter();
    }

    public function jsonSerialize()
    {
        throw new NotImplementedException();
    }

    public function save()
    {
        $fields = $this->getPublicVars();
        unset($fields['id']);
        $db_fields = [];

        if ($this->id) {
            unset($fields['created_at']);
            $this->updated_at = new DateTime();
        }

        foreach ($fields as $field_name => $value) {
            $value_type = gettype($value);
            switch ($value_type) {
                case 'NULL':
                    $db_fields[$field_name] = 'NULL';
                    break;
                case 'boolean':
                case 'integer':
                case 'string':
                case 'double':
                    $db_fields[$field_name] = $value;
                    break;
                case 'object':
                    switch (get_class($value)) {
                        case 'DateTime':
                            $db_fields[$field_name] = $value->format('Y-m-d H:i:s');
                            break;
                        default:
                            throw (new NotImplementedException('Please handle this object type'));
                            break;
                    }
                    break;
                default:
                    throw (new NotImplementedException('Please handle this type'));
                    break;
            }
        }

        if (is_null($this->id)) {
            $sql = 'INSERT INTO ' . static::TABLE_NAME;
            $columns = '(' . implode(', ', array_keys($db_fields)) . ')';
            $sql .= " $columns";

            $values = '(' . sprintf('"%s"', implode('","', array_values($db_fields))) . ')';
            $sql .= " VALUES $values;";

            $connection = $this->database->getConnection();
            $connection->exec($sql);

            $this->id = $connection->lastInsertId();

            return true;
        }

        $sql = 'UPDATE ' . static::TABLE_NAME;
        $sql .= ' SET ';

        $key_value = [];
        foreach ($db_fields as $field => $value) {
            $key_value[] = "$field=\"$value\"";
        }
        $sql .= implode(', ', $key_value);
        $sql .= ' WHERE id = ' . $this->id . ';';

        $connection = $this->database->getConnection();
        $connection->exec($sql);

        return true;
    }

    public static function find(int $id)
    {
        $sql = 'SELECT * FROM ' . static::TABLE_NAME . " WHERE id = $id LIMIT 1;";
        $conn = static::getConnection();
        $stmt = $conn->query($sql);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $record = $stmt->fetch();

        if ($record) {
            $entity_class = get_called_class();
            $entity = new $entity_class();
            $fields = get_object_vars($record);
            foreach ($fields as $field_name => $value) {
                if (DateTime::createFromFormat('Y-m-d H:i:s', $value) !== false) {
                    $entity->$field_name = new DateTime($value);
                    continue;
                }
                $entity->$field_name = $value;
            }

            return $entity;
        }

        throw (new RecordNotFoundException("Can't find row with ID $id in table " . static::TABLE_NAME));
    }

    public function destroy()
    {
        if (is_null($this->id)) {
            throw (new ActiveRecordException("Can't delete a row without an id"));
        }

        static::delete($this->id);
    }

    public static function delete(int $id)
    {
        static::find($id);

        $sql = 'DELETE FROM ' . static::TABLE_NAME . " WHERE id = $id";
        $conn = static::getConnection();
        $conn->exec($sql);
    }

    protected static function getConnection()
    {
        if (static::$db_conn) {
            return static::$db_conn->getConnection();
        }

        return (new MysqlDBAdapter())->getConnection();
    }

    protected function getPublicVars()
    {
        $instance = new class
        {
            function getPublicVars($object)
            {
                return get_object_vars($object);
            }
        };
        return $instance->getPublicVars($this);
    }
}
