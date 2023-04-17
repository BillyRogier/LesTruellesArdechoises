<?php

namespace Core\Table;

use App;

class Table
{
    protected $table;
    protected $tableJoin;
    protected $db;

    public function __construct(
        protected $join = []
    ) {
        $this->db = App::getInstance()->getDb();
        if (!empty($join)) {
            foreach ($join as $cle => $value) {
                $this->setJoin($cle);
            }
        }
        $this->tableJoin = $this->table;
    }

    private function getQuestionMarks(array $array)
    {
        return implode(',', array_fill(0, count($array), '?'));
    }

    private function getCle(array $array)
    {
        return implode(',', $array);
    }

    private function getSet(array $array)
    {
        return implode(' = ?, ', $array) . ' = ?';
    }

    private function getWhere($array)
    {
        $params = "";
        foreach ($array as $cle => $value) {
            if ($value == NULL && $value != "") {
                $params .= " " . $cle . " IS NULL AND";
            } else {
                $params .= " " .  $cle . "= ? AND";
            }
        }
        return substr($params, 0, -3);
    }

    private function getValues($array)
    {
        $values = [];
        foreach ($array as $cle => $value) {
            if (!is_null($value)) {
                array_push($values, $value);
            }
        }
        return $values;
    }

    public function find(string $request, array $values)
    {
        return $this->db->prepare("SELECT * FROM " .  $this->tableJoin . " " . $request, $values, get_class($this), $this->join);
    }

    public function findBy($array, $attributes = null): static|bool
    {
        return $this->db->prepare("SELECT " . $this->getCle($array) . " FROM " . $this->table . " WHERE " . $this->getWhere($attributes) . "", $this->getValues($attributes), get_class($this));
    }

    public function findAll($options = "")
    {
        return $this->db->query("SELECT * FROM " . $this->tableJoin . " $options", get_class($this), [$this->join]);
    }

    public function findAllBy($attributes = null, $options = "")
    {
        return $this->db->prepare("SELECT * FROM " . $this->tableJoin . " WHERE " . $this->getWhere($attributes) . " $options", $this->getValues($attributes), get_class($this), $this->join);
    }

    public function findOne(): static|bool
    {
        return $this->db->query("SELECT * FROM " . $this->tableJoin . " WHERE 1", get_class($this), $this->join, true);
    }

    public function findOneBy($attributes = null): static|bool
    {
        return $this->db->prepare("SELECT * FROM " . $this->tableJoin . " WHERE " . $this->getWhere($attributes) . "", $this->getValues($attributes), get_class($this), $this->join, true);
    }

    public function update($structure, $where, $attributes = null)
    {
        return $this->db->prepare("UPDATE " . $this->table . " SET " . $this->getSet($structure) . " WHERE $where = ?", $attributes, get_class($this));
    }

    public function insert($structure, $attributes = null)
    {
        return $this->db->prepare("INSERT INTO " . $this->table . "(" . $this->getCle($structure) . ") VALUES(" . $this->getQuestionMarks($structure) . ")", $attributes, get_class($this));
    }

    public function delete($attributes = null)
    {
        $this->db->prepare("DELETE FROM " . $this->table . " WHERE " . $this->getWhere($attributes) . ";", $this->getValues($attributes));
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * Get the value of join
     */
    public function getJoin($table)
    {
        return $this->join[$table];
    }

    /**
     * Set the value of join
     *
     * @return  self
     */
    public function setJoin($join)
    {
        $Table = new $join();
        $this->join[$join] = $Table;
        return $this;
    }

    public function innerJoin($table)
    {
        return $this->join($table, "INNER");
    }

    public function rightJoin($table)
    {
        return $this->join($table, "RIGHT");
    }

    public function leftJoin($table)
    {
        return $this->join($table, "LEFT");
    }

    public function join($table, $type = ""): static
    {
        $this->setJoin($table);
        $this->tableJoin = $this->tableJoin . " $type JOIN " . $this->getJoin($table)->table . "";
        return $this;
    }

    public function on($condition): static
    {
        $this->tableJoin = $this->tableJoin . " ON $condition";
        return $this;
    }

    public function getJoinValues($classnames, $name, $value)
    {
        foreach ($classnames as $class) {
            $method = "set" . ucfirst($name);
            if (method_exists($class, $method) && !isset($class->$name)) {
                $class->$method($value);
            }
        }
    }

    public function __set($name, $value)
    {
        $this->getJoinValues($this->join, $name, $value);
    }
}
