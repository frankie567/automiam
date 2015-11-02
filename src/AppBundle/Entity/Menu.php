<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MenuRepository")
 */
class Menu
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="menus")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="beginDate", type="date")
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today")
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date")
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today")
     */
    private $endDate;
    
    /**
     * @ORM\OneToMany(targetEntity="DayMenu", mappedBy="menu", cascade={"persist", "remove"})
     */
    private $dayMenus;


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
     * Set beginDate
     *
     * @param \DateTime $beginDate
     *
     * @return Menu
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * Get beginDate
     *
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Menu
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    /**
     * Constructor
     */
    public function __construct($user)
    {
        $this->setUser($user);
        $this->dayMenus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add dayMenu
     *
     * @param \AppBundle\Entity\DayMenu $dayMenu
     *
     * @return Menu
     */
    public function addDayMenu(\AppBundle\Entity\DayMenu $dayMenu)
    {
        $this->dayMenus[] = $dayMenu;

        return $this;
    }

    /**
     * Remove dayMenu
     *
     * @param \AppBundle\Entity\DayMenu $dayMenu
     */
    public function removeDayMenu(\AppBundle\Entity\DayMenu $dayMenu)
    {
        $this->dayMenus->removeElement($dayMenu);
    }

    /**
     * Get dayMenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDayMenus()
    {
        return $this->dayMenus;
    }
    
    public function getDayMenuById($id)
    {
        foreach ($this->getDayMenus() as $dayMenu)
        {
            if ($dayMenu->getId() == $id)
            {
                return $dayMenu;
            }
        }
        return null;
    }
    
    public function getAllRecipes()
    {
        $recipes = array();
        foreach ($this->getDayMenus() as $dayMenu)
        {
            foreach ($dayMenu->getMenuRecipes() as $menuRecipe)
            {
                $recipes[] = $menuRecipe->getRecipe();
            }
        }
        return $recipes;
    }
    
    /**
     * @Assert\Callback
     */
    public function beginDateLessThanEndDate(ExecutionContextInterface $context)
    {
        if ($this->getEndDate() < $this->getBeginDate())
        {
            $context->buildViolation('automiam.menu.new.begin_date_less_than_end_date')
                ->atPath('beginDate')
                ->addViolation();
        }
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Menu
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;
        $user->addMenu($this);
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
}
