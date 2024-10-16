<?php
namespace App\Model;

use App\helpers\Text;
use DateTime;

class Post{

    private $id;

    private $name;
     
    private $content;

    private $created_at;

    private $categories = [];

    public $slug ;

    
    public function getFormattedContent(): ?string{
        return nl2br(e($this->content));
    }

    public function getName(): ?string{
        return $this->name;
    }

    public function getSlug(): ?string{
        return $this->slug;
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getExcerpt(): ?string{
        if($this->content === null){
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, 60)));
    }

    public function getCreatedAt(): ?DateTime{
        if($this->created_at === null){
            return null;
        }
        return new DateTime($this->created_at);


    }

    public function addcategory(Category $category): void{
        $this->categories[] = $category;
        $category->setPost($this);
    }

    /**
     * @return Category[]
     */
    public function getCategories (): array {
        return $this->categories;
    }

    public function setName(string $name): self{
        $this->name = $name;
        return $this;
    }

    public function setContent(string $content): self{
        $this->content = $content;
        return $this;
    }

    public function getContent(): ?string{
        return $this->content;
    }

    public function setSlug(string $slug): self{
        $this->slug = $slug;
        return $this;
    }

    public function setCreatedAt(string $created_at): self{
        $this->created_at =  $created_at;  

        return $this;
    }

    public function setId(int $id): self{
        $this->id = $id;
        return $this;
    }

    public function getCategoriesIDs (): array{
        $ids = [];
        foreach($this->categories as $category){
            $ids[] = $category->getID();
        }
        return $ids;
    }

    public function setCategories (array $categories): self {
        $this->categories = $categories ;
        return $this;
    }

    

    

    
}