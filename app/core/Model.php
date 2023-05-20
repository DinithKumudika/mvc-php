<?php

namespace App\Core;

/*
     Base Model Class
*/

class Model {

     protected string $table ='users';
     protected int $limit = 5;
     protected int $offset = 0;

     public function where(array $data)
     {
          $columns = array_keys($data);
          $query = "SELECT * FROM {$this->table} WHERE ";

          foreach($columns as $column){
               $query .= "{$column} = :{$column} && ";
          }

          $query = trim($query, " && ");
          $query .= " LIMIT {$this->limit} OFFSET {$this->offset}";

          echo $query;
     }

     public function first(array $data)
     {
          $columns = array_keys($data);
          $query = "SELECT * FROM {$this->table} WHERE ";

          foreach($columns as $column){
               $query .= "{$column} = :{$column} && ";
          }

          $query = trim($query, " && ");
          $query .= " LIMIT {$this->limit} OFFSET {$this->offset}";

          echo $query;
     }
     
     public function insert(array $data)
     {
          $columns = array_keys($data);
          $query = "INSERT INTO {$this->table} (". implode(",", $columns) .") VALUES (:". implode(",:", $columns) .")";

          echo $query;
     }

     public function update(int $id, array $data, $id_column = 'id')
     {
          $columns = array_keys($data);
          $query = "UPDATE {$this->table} SET ";
     }

     public function delete(int $id, $id_column = 'id')
     {
          $query = "DELETE FROM {$this->table} WHERE {$id_column} = :{$id_column}";
          echo $query;
     }
}