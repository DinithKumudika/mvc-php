<?php

namespace App\Services;

use PDO;
use PDOException;
use PDOStatement;

Class Database {

     private PDO $connection;
     private PDOStatement $stmt;
     
     public function __construct(array $config)
     {
          try {

               $dsn = "{$config['conn']}:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

               $options = [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
               ];
               
               $this->connection = new PDO($dsn, $config['user'], $config['pass'], $options);
          } 
          catch (PDOException $e) {
               echo $e->getMessage(); 
          }
     }

     public function getConnection(): PDO
     {
          return $this->connection;
     }

     private function prepare(string $sql): void
     {
          $this->stmt = $this->connection->prepare($sql);
     }

     private function execute(array $params): bool
     {
          return $this->stmt->execute($params);
     }

     private function fetch(): object|false
     {
          return $this->stmt->fetch();
     }

     private function fetchAll(): array|false
     {
          return $this->stmt->fetchAll();
     }

     public function rowCount(): int
     {
          return $this->stmt->rowCount();
     }

     public function query(string $sql, array $params = []): object|false
     {
          $this->prepare($sql);

          if($this->execute($params)){
               $result = $this->fetch();

               if(is_object($result) && $this->rowCount() > 0)
               {
                    return $result;
               }
          }
          
          return false; 
     }

     public function queryAll(string $sql, array $params = []): array|false
     {
          $this->prepare($sql);

          if($this->execute($params)) 
          {
               $results = $this->fetchAll();

               if(is_array($results) && $this->rowCount() > 0)
               {
                    return $results;
               }
          }
          
          return false;
     }
}