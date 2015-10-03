<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuRecipe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MenuRecipeRepository")
 */
class MenuRecipe
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
     * @ORM\ManyToOne(targetEntity="Recipe")
     */
    private $recipe;
    
    /**
     * @ORM\ManyToOne(targetEntity="DayMenu", inversedBy="menuRecipes")
     */
    private $dayMenu;
    
    public function __construct($recipe)
    {
        $this->setRecipe($recipe);
    }

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
     * Set recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return MenuRecipe
     */
    public function setRecipe(\AppBundle\Entity\Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \AppBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set dayMenu
     *
     * @param \AppBundle\Entity\DayMenu $dayMenu
     *
     * @return MenuRecipe
     */
    public function setDayMenu(\AppBundle\Entity\DayMenu $dayMenu = null)
    {
        $this->dayMenu = $dayMenu;

        return $this;
    }

    /**
     * Get dayMenu
     *
     * @return \AppBundle\Entity\DayMenu
     */
    public function getDayMenu()
    {
        return $this->dayMenu;
    }
}
