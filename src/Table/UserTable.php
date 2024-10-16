<?php
namespace App\Table;

//require_once 'CategoryTable.php';

use App\Model\User;
use App\PaginatedQuery;
use App\Table\Exception\NotFoundException;
use App\Table\Table;
use App\Table\CategoryTable;
use Exception;
use PDO;

final class UserTable extends Table{

    protected $table = "user";
    protected $class  = User::class;

    public function findByusername(string $username){
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table .' WHERE username= :username');
        $query->execute(['username' => $username]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false){
            throw new NotFoundException($this->table, $username);
        }
        return $result;
    }


    
}