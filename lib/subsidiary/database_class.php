<?php

    /**
    * Building of basic sql querries that are used in core model class.
    **/

    require_once "config_class.php";

    class DataBase {

    private $mysqli;
    private $config;

        public function __construct() {
            $this->config = new Config();
            $this->mysqli = new mysqli($this->config->host, $this->config->user, $this->config->password, $this->config->db);  // setting up DB connection
        }

        public function select($fields, $table, $where='', $order = '', $up = true, $limit = '') {
            $table = $this->config->prefix.$table;
            $request = "SELECT ";
            foreach ($fields as $value) {
                if ($value != '*' && !strpos($value, '(')) $request .= "`".addslashes($value)."`,";
                else $request .= $value.',';
            }
            $request = substr($request, 0, strlen($request) - 1);

            $request .= " FROM `$table`";
            if ($where != '') {
                $request .= " WHERE $where";
            }
            if ($order != '') {
                $request .= " ORDER BY `$order`";
                if (!$up) {
                    $request .= ' DESC';
                }
            }
            if ($limit != '') {
                $request .= " LIMIT $limit";

            }
            $result = $this->mysqli->query($request);
            $i = 0;
            if (!$result) return false;
            while ($row = $result->fetch_assoc()) {
                $data[$i] = $row;
                $i++;
            }
            $result->close();
            return $data;
        }

        public function insert($table, $fields, $values) {
            $table = $this->config->prefix.$table;
            $request = "INSERT INTO `$table` (";
            foreach ($fields as $value) {
                $request .= '`'.addslashes($value).'`,';
            }
            $request = substr($request, 0, strlen($request) - 1);
            $request .= ') VALUES (';
            foreach ($values as $value) {
                $request .= "'".addslashes($value)."',";
            }
            $request = substr($request, 0, strlen($request) - 1);
            $request .= ')';
            $this->mysqli->query($request);
            return $this->mysqli->affected_rows;
        }

        public function update($table, $fields, $values, $where) {
            $table = $this->config->prefix.$table;
            $request = "UPDATE `$table` SET ";
            for ($i = 0; $i < count($fields); $i++) {
                $request .= "`$fields[$i]` = '".addslashes($values[$i])."',";
            }
            $request = substr($request, 0, strlen($request) - 1);
            $request .= " WHERE $where";        
            $this->mysqli->query($request);
            return $this->mysqli->affected_rows;
        }

        public function delete($table, $where) {
            $table = $this->config->prefix.$table;
            $request = "DELETE FROM `$table` WHERE $where";
            $this->mysqli->query($request);
            return $this->mysqli->affected_rows;
        }

    }

?>