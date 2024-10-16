<?php
namespace App\Table\Exception;


class NotFoundException extends \Exception{
    public function __construct(string $table , $id = 0){
        $this->message = "Aucune catégorie ne correspond à l'id #$id dans la table '$table'";
    }
}