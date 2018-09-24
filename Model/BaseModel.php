<?php
/**
 * Created by PhpStorm.
 * User: przem
 * Date: 23.09.2018
 * Time: 12:53
 */

namespace MiniFw\Model;


use MiniFw\Lib\Db;
use MiniFw\Lib\Di;
use MiniFw\Lib\ModelManager;

/**
 * Class BaseModel
 * @package MiniFw\Model
 */
abstract class BaseModel
{
    /** @var Db */
    private $db;

    public $id;

    /**
     * BaseModel constructor.
     * @param int|null $id
     */
    public function __construct(int $id = null)
    {
        $this->db = Di::get('db');
        if ($id = (int)$id) {
            $this->get($id);
        }
    }

    /**
     * Get table name
     * @return string
     */
    public static function getSource(): string
    {
        return mb_strtolower(substr(strrchr(static::class, "\\"), 1));
    }

    /**
     * Sanitize model data
     */
    abstract protected function sanitize(): void;

    /**
     * Fetches record
     * @param $id
     */
    private function get($id): void
    {
        $data = $this->db->getQuery('SELECT * FROM ' . static::getSource() . ' WHERE id=:id', ['id' => $id]);
        $this->assign($data[0]);
    }

    /**
     * Fetches records
     * @return static[]
     */
    public static function find(string $condition = null, array $bindValues = [], $order = 'ASC'): array
    {
        $sql = 'SELECT * FROM ' . static::getSource();
        if ($condition) {
            $sql .= ' WHERE ' . $condition;
        }
        $sql .= ' ORDER BY id ' . $order;
        $data = Di::get('db')->getQuery($sql, $bindValues);
        $result = [];
        foreach ($data as $datum) {
            $result[] = $model = new static();
            $model->assign($datum);
        }
        return $result;
    }

    /**
     * Returns array of model
     * @param array $exclude
     * @return array
     */
    public function toArray(array $exclude = []): array
    {
        $result = [];
        foreach (ModelManager::getModelProperties($this, $exclude) as $property) {
            $result[$property] = $this->$property;
        }
        return $result;
    }

    /**
     * Insert model to db
     */
    public function insert(): void
    {
        $this->sanitize();
        $properties = ModelManager::getModelProperties($this, ['id']);
        $stmtProperties = array_map(function ($column) {
            return ':' . $column;
        }, $properties);

        $this->db->query('INSERT INTO ' . static::getSource() . ' (' . implode(',', $properties) . ') VALUES (' . implode(',', $stmtProperties) . ')', $this->toArray(['id']));
    }

    /**
     * Update model in db
     */
    public function update(): void
    {
        $this->sanitize();
        $stmtProperties = array_map(function ($column) {
            return $column . '= :' . $column;
        }, ModelManager::getModelProperties($this, ['id']));

        $this->db->query('UPDATE ' . static::getSource() . ' SET ' . implode(',', $stmtProperties) . ' WHERE id=:id', $this->toArray());
    }

    public function delete(): void
    {
        $this->sanitize();
        $this->db->query('DELETE FROM ' . static::getSource() . ' WHERE id=:id', ['id' => $this->id]);
        $this->db->query('VACUUM;');
    }

    /**
     * Assign data to model
     * @param array $data
     */
    public function assign(array $data): void
    {
        foreach ($data as $property => $value) {
            if (property_exists($this,$property)) {
                $this->$property=$value;
            }
        }
    }
}