<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DayMenu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DayMenuRepository")
 */
class DayMenu
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
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="date")
     */
    private $day;
    
    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="dayMenus")
     */
    private $menu;
    
    /**
     * @ORM\OneToMany(targetEntity="MenuRecipe", mappedBy="dayMenu", cascade={"persist", "remove"})
     */
    private $menuRecipes;

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
     * Set day
     *
     * @param \DateTime $day
     *
     * @return DayMenu
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set menu
     *
     * @param \AppBundle\Entity\Menu $menu
     *
     * @return DayMenu
     */
    public function setMenu(\AppBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;
        $menu->addDayMenu($this);
        return $this;
    }

    /**
     * Get menu
     *
     * @return \AppBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Add menuRecipe
     *
     * @param \AppBundle\Entity\MenuRecipe $menuRecipe
     *
     * @return DayMenu
     */
    public function addMenuRecipe(\AppBundle\Entity\MenuRecipe $menuRecipe)
    {
        $this->menuRecipes[] = $menuRecipe;
        $menuRecipe->setDayMenu($this);
        return $this;
    }

    /**
     * Remove menuRecipe
     *
     * @param \AppBundle\Entity\MenuRecipe $menuRecipe
     */
    public function removeMenuRecipe(\AppBundle\Entity\MenuRecipe $menuRecipe)
    {
        $this->menuRecipes->removeElement($menuRecipe);
    }

    /**
     * Get menuRecipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenuRecipes()
    {
        return $this->menuRecipes;
    }
}
