<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts")
     * @ORM\JoinColumn(name="category", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $intro;

    /**
     * @var Collection|TextContent[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\TextContent", mappedBy="post", cascade={"persist"})
     */
    private $textContentList;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @var Collection|Comment[]
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post")
     */
    private $comments;


    public function __construct()
    {
        $this->textContentList = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return Post
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * @param mixed $intro
     * @return Post
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
        return $this;
    }

    /**
     * @return TextContent[]|Collection
     */
    public function getTextContentList()
    {
        return $this->textContentList;
    }

    /**
     * @param TextContent[]|Collection $textContentList
     * @return Post
     */
    public function setTextContentList($textContentList)
    {
        $this->textContentList = $textContentList;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * @param mixed $publishDate
     * @return Post
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param mixed $published
     * @return Post
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }



    /**
     * @param TextContent $textContent
     * @return $this
     */
    public function addTextContentList(TextContent $textContent): self
    {
        if ( !$this->getTextContentList()->contains($textContent) ) {
            $this->getTextContentList()->add($textContent);
            $textContent->setPost($this);
        }
        return $this;
    }

    /**
     * @param TextContent $textContent
     * @return $this
     */
    public function removeTextContentList(TextContent $textContent): self
    {
        if ( $this->textContentList->contains($textContent) ) {
            $this->textContentList->removeElement($textContent);
        }

        return $this;
    }
}
