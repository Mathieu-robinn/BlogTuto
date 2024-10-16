<?php

namespace App\Model;

class Category{
    private $id;
    private $slug;
    private $name;
    private $post_id;
    private $post;

    public function getID(): ?int{
        return $this->id;
    }

    public function getSlug(): ?string{
        return $this->slug;
    }

    public function getName(): ?string{
        return $this->name;
    }

    public function getPostID(): ?int{
        return $this->post_id;
    }

    public function setPost(Post $post): self {
        $this->post = $post;

        return $this;
    }
    
    public function setPostId(int $post_id): self {
        $this->post_id = $post_id;
        return $this;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function setSlug(string $slug): self {
        $this->slug = $slug;
        return $this;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getPost(): Post{
        return $this->post;
    }
    



}