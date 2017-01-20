<?php

    /**
    * Core model class according to MVC architecture
    **/

    require_once "database_class.php";
    require_once "check_class.php";
    require_once "config_class.php";

    abstract class GlobalClass {

        private $db;
        private $check;
        private $table;
        protected $config;

        protected function __construct($table) {     // $table - name of the table model class is working with
            $this->db = new DataBase();
            $this->check = new Check();
            $this->config = new Config();
            $this->table = $table;
        }

        public function update($fields, $values, $where){
            return  $this->db->update($this->table, $fields, $values, $where);
        }

        public function updateUniqueField($field, $value, $where){                // Updating field. Used for unique fields only
            $fields = array($field);
            $values = array($value);
            return  $this->db->update($this->table, $fields, $values, $where);
        }

        public function insert($fields, $values){
            return  $this->db->insert($this->table, $fields, $values);
        }

        public function getAllStrings(){                                          // Getting all records from the table
            $result = $this->db->select(array('*'), $this->table);
            if (!$result) return false;
            return $result;
        }

        protected function getSumOfFields($sum_field, $where=''){                 // Getting sum of fields
            $field = array('SUM(`'.$sum_field.'`) AS `sumfield`');
            if ($where != '') {
                $where_req = '';
                foreach ($where as $key => $value) {
                    $where_req .= "`$value` = '$key' OR ";
                }
                $where = substr($where_req, 0, strlen($where_req) - 3);
            }
            $result = $this->db->select($field, $this->table, $where);
            if (!$result) return false;
            return $result[0]['sumfield'];
        }

        public function getStringOnField($field, $value, $limit='') {             // Getting record on field value
            $value = addslashes($value);
            $where = "`$field` = '$value'";
            $result = $this->db->select(array('*'), $this->table, $where, '', true, $limit);
            if (!$result) return false;
            return $result;
        }

        public function getStringOnID($id) {                                      // Getting record on id value
            if (!$this->check->checkID($id)) return false;
            $result = $this->getStringOnField('id', $id);
            if (!$result) return false;
            return $result[0];
        }

        public function getFieldOnField($field_in, $value_in, $field_out) {       // Getting field on field value
            $value = addslashes($value_in);
            $where = "`$field_in` = '$value_in'";
            $result = $this->db->select(array($field_out), $this->table, $where);
            if (!$result) return false;
            return $result;
        }

        public function getFieldOnID($id, $field_out) {                           // Getting field on id value
            if (!$this->check->checkID($id)) return false;
            $result = $this->getFieldOnField('id', $id, $field_out);
            if (!$result) return false;
            return $result[0];
        }

        public function getNStrings($n){                                          // Getting N quantity of records
            $result = $this->db->select(array('*'), $this->table, '', '', true, $n);
            if (!$result) return false;
            return $result;
        }

        public function getNStringsOrder($order, $up, $n, $id=''){                // Getting N quantity of records considering ascending or descending parameters
            if ($id != '') $id = '`section_id`='.$id;
            $result = $this->db->select(array('*'), $this->table, $id, $order, $up, $n);
            if (!$result) return false;
            return $result;
        }

        public function delete($where) {
            return $this->db->delete($this->table, $where);
        }

    }

 ?>