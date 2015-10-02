<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="user")
     */
    private $recipes;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return User
     */
    public function addRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        $this->recipes[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     */
    public function removeRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        $this->recipes->removeElement($recipe);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipes()
    {
        return $this->recipes;
    }
}
