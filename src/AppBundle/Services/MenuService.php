<?php

namespace AppBundle\Services;

use AppBundle\Entity\DayMenu;

class MenuService
{
    /* Create a DayMenu for each day (if not already done) */
    public function prepareDayMenus($menu)
    {
        if (count($menu->getDayMenus()) == 0)
        {
            $currentDate = clone $menu->getBeginDate();
            while ($currentDate <= $menu->getEndDate())
            {
                $dayMenu = new DayMenu();
                $dayMenu->setDay(clone $currentDate);
                $dayMenu->setMenu($menu);
                
                $currentDate->add(new \DateInterval('P1D'));
            }
        }
    }
}