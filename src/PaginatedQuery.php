<?php
namespace App;

use Exception;
use PDO;
use App\URL;

class PaginatedQuery{

    private  $query;
    private $queryCount;
    private $pdo;
    private $perpage;
    private $count;
    private $items;
    public function __construct(
        string $query,
        string $queryCount,
        ?PDO $pdo = null,
        $perpage = 12
        
    ){
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perpage = $perpage;
    }

    public function GetItems(string $classMapping): array {
        if($this->items === null){
            $currentpage = $this->getCurrentpage();
            $count = (int)$this->pdo
                ->query($this->queryCount)
                ->fetch(PDO::FETCH_NUM)[0];
            $pages = ceil($count / $this->perpage);
            if($currentpage >  $pages){
                throw new Exception('Cette page n\'existe pas');
            }
            $offset = $this->perpage * ($currentpage - 1);
            
            $this->items = $this->pdo->query(
                $this->query . 
                " LIMIT {$this->perpage} OFFSET $offset")
                ->fetchAll(PDO::FETCH_CLASS, $classMapping );
        }
        return $this->items;
    }
    
    public function previousLink(string $link): ?string {
        $currentPage = $this->getCurrentpage();
        if ($currentPage <= 1) return null;
        if($currentPage >  2) $link.= "?page=" . ($currentPage - 1);
        return <<<HTML
        <a href="{$link}" class="btn btn-primary">&laquo; Page précédente</a>
HTML;
    }

    public function nextLink(string $link): ?string {
        $currentPage = $this->getCurrentpage();
        $pages = $this->getpages();
        if ($currentPage >=  $pages) return null;
        $link.= "?page=" . ($currentPage + 1);
        return <<<HTML
        <a href="{$link}" class="btn btn-primary ml-auto">Page suivante &raquo; </a>
HTML;
    }

    private function getCurrentpage(): int{
        return URL::getPositiveInt('page', 1);
    }

    private function getPages(): int{
        if($this->count === null){
            $this->count = (int)$this->pdo
                ->query($this->queryCount)
                ->fetch(PDO::FETCH_NUM)[0];
        }
        return ceil($this->count / $this->perpage);
    }
}