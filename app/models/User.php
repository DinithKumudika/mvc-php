<?php

use App\Core\Model;

/** user model */

class User extends Model{
     
     /**
     * The table associated with the model.
     *
     * @var string
     */
     protected string $table = 'users';

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
     protected string $primaryKey = 'user_id';
     
     public function __construct()
     {
          parent::$table = $this->table;
          parent::$primaryKey = $this->primaryKey;
     }


}