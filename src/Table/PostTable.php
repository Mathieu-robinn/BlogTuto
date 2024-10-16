<?php
namespace App\Table;

//require_once 'CategoryTable.php';

use App\Model\Post;
use App\PaginatedQuery;
use App\Table\Exception\NotFoundException;
use App\Table\Table;
use App\Table\CategoryTable;
use Exception;
use PDO;

final class PostTable extends Table{

    protected $table = "post";
    protected $class  = Post::class;

    public function findPaginated(){
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM {$this->table} ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM {$this->table}",
            $this->pdo
        );
        $posts = $paginatedQuery->GetItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory(int $categoryID){
        $paginatedQuery = new PaginatedQuery(
            "SELECT p.*
            FROM {$this->table} p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$categoryID}
            ORDER BY created_at DESC ",
            "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryID}",
        );
        $posts = $paginatedQuery->GetItems($this->class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }


    public function updatePost(Post $post): void{
       
        $this->update([
            'name' => $post->getName(), 
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ], $post->getId()); 
    }

    public function createPost(Post $post): void{
        
        $id = $this->create([
            'name' => $post->getName(), 
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        $post->setid($id); 
    }

    public function attachCategories (int $id, array $categories){
        $this->pdo->exec('DELETE FROM post_category WHERE post_id = ' . $id);
        $query = $this->pdo->prepare('INSERT INTO post_category SET post_id = ? , category_id = ? ');
        foreach($categories as $category){
            $query->execute([$id, $category]);
        }   
    }

    public function all (): array {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";  
        return $this->pdo->query($sql,PDO::FETCH_CLASS, $this->class )->fetchAll();
    }



    
}