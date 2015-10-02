<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $aperitif = new Category("Apéritif");
        $manager->persist($aperitif);
        
        $entree = new Category("Entrée");
        $manager->persist($entree);
        
        $plat = new Category("Plat principal");
        $manager->persist($plat);
        
        $dessert = new Category("Dessert");
        $manager->persist($dessert);

        $manager->flush();
    }
}