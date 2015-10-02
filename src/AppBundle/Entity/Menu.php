<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     *
     * @ORM\Column(name="beginDate", type="date")
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date")
     */
    private $endDate;
    
    /**
     * @ORM\OneToMany(targetEntity="DayMenu", mappedBy="menu")
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
    public function __construct()
    {
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
}
