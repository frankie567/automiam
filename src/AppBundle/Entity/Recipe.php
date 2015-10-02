<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Recipe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RecipeRepository")
 */
class Recipe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recipes")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message = "automiam.recipe.new.name_required")
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="recipe", type="text", nullable=true)
     */
    private $recipe;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="recipes")
     * @Assert\NotBlank(message = "automiam.recipe.new.category_required")
     */
    private $category;
    
    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="recipes")
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "automiam.recipe.new.one_tag_minimum",
     * )
     */
    private $tags;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set recipe
     *
     * @param string $recipe
     *
     * @return Recipe
     */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return string
     */
    public function getRecipe()
    {
        return $this->recipe;
    }
    
    /**
     * Constructor
     */
    public function __construct(User $user)
    {
        $this->setUser($user);
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Recipe
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;
        $user->addRecipe($this);
        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Recipe
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;
        $category->addRecipe($this);
        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Recipe
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;
        $tag->addRecipe($this);
        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
        $tag->removeRecipe($this);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Recipe
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
