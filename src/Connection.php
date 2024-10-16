<?php
namespace App;

use Exception;
use PDO;
use PDOException;

class Connection{
    public static function getPDO(): PDO{
        try{
            $pdo = new PDO('mysql:dbname=tutoblog;host=127.0.0.1', 'root', 'root');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die('Erreur PDO '. $e->getMessage());
        }catch(Exception $e){
            die('Erreur PDO '. $e->getMessage());
        }
        return $pdo;
    } 
}