<?php
namespace App\Table;

use App\Model\Category;
use App\Model\Post;
use App\Table\Exception\NotFoundException;
use PDO;
use App\Table\Table;
use Exception;

final class CategoryTable extends Table{

    protected $table = "category";
    protected $class  = Category::class;

    

    /**
     * Summary of hydratePosts
     * @param App\Model\Post[] $posts
     * @return void
     */
    public function hydratePosts(array $posts): void{
        $postByID= [];
        
        foreach($posts as $post){
            $post->setCategories([]);
            $postByID[$post->getId()] = $post;
        }
        $categories = $this->pdo
            ->query(
                'SELECT c.*, pc.post_id
                FROM post_category pc
                JOIN category c ON c.id = pc.category_id
                WHERE pc.post_id IN (' . implode(',', array_keys($postByID)) . ')'
            )->fetchAll(PDO::FETCH_CLASS, $this->class);
                
        
        foreach($categories as $category){
            $postByID[$category->getPostID()]->addcategory($category);
        }

        
    }

    public function all (): array {
        return $this->queryAndFfetchAll( "SELECT * FROM {$this->table} ORDER BY id DESC" );  
    }
    
    public function list(): array{
        $categories = $this->queryAndFfetchAll( "SELECT * FROM {$this->table} ORDER BY name ASC" );
        $results = [];
        foreach($categories as $category){
            $results[$category->getID()] = $category->getName(); 
        }
        return $results;
    }


    

    
}