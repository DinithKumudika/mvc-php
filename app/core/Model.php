<?php

namespace App\Core;

/*
     Base Model Class
*/

class Model {

     protected string $table ='users';
     protected string $primaryKey = 'id';
     protected int $limit = 5;
     protected int $offset = 0;
     protected string $order = "desc";
     protected string $order_column = "id";
     protected array $allowedColumns = [];

     // get all records
     public function all()
     {
          $query = "SELECT * FROM `{$this->table}` ORDER BY `{$this->order_column}`";

          echo $query;
     }

     // get record by primary key
     public function find($key)
     {
          $query = "SELECT * FROM `{$this->table}` WHERE {$this->primaryKey} = :{$this->primaryKey} ORDER BY `{$this->order_column}` {$this->order} LIMIT {$this->limit} OFFSET {$this->offset}";

          echo $query;
     }

     public function findOrFail($key)
     {

     }

     public function take($limit)
     {
          $this->limit = $limit;
     }

     public function where(array $data)
     {
          $columns = array_keys($data);
          $query = "SELECT * FROM `{$this->table}` WHERE ";

          foreach($columns as $column){
               $query .= "`{$column}` = :{$column} && ";
          }

          $query = trim($query, " && ");
          $query .= " ORDER BY `{$this->order_column}` {$this->order} LIMIT {$this->limit} OFFSET {$this->offset}";

          echo $query;
     }

     public function first(array $data)
     {
          $columns = array_keys($data);
          $query = "SELECT * FROM `{$this->table}` WHERE ";

          foreach($columns as $column){
               $query .= "`{$column}` = :{$column} && ";
          }

          $query = trim($query, " && ");
          $query .= " LIMIT {$this->limit} OFFSET {$this->offset}";

          echo $query;
     }
     
     public function insert(array $data)
     {
          if(!empty($this->allowedColumns)){
               foreach($data as $key => $value){
                    if(!in_array($key, $this->allowedColumns)){
                         unset($data[$key]);
                    }
               }
          }
          
          $columns = array_keys($data);
          $query = "INSERT INTO `{$this->table}` (". implode(",", $columns) .") VALUES (:". implode(",:", $columns) .")";

          echo $query;
     }

     public function update(int $id, array $data, $id_column = 'id')
     {
          if(!empty($this->allowedColumns)){
               foreach($data as $key => $value){
                    if(!in_array($key, $this->allowedColumns)){
                         unset($data[$key]);
                    }
               }
          }
     
          $columns = array_keys($data);
          $query = "UPDATE `{$this->table}` SET ";

          foreach($columns as $column){
               $query .= "`{$column}` = :{$column}, ";
          }

          $query = trim($query, ", ");
          $query .= " WHERE `{$id_column}` = :{$id_column}";
          $data[$id_column] = $id;

          echo $query;
     }

     public function delete(int $id, $id_column = 'id')
     {
          $query = "DELETE FROM `{$this->table}` WHERE `{$id_column}` = :{$id_column}";
          echo $query;
     }
}