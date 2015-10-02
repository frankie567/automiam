<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\Tag;

class LoadTagData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $rapide = new Tag("Rapide");
        $manager->persist($rapide);
        
        $amis = new Tag("Entre amis");
        $manager->persist($amis);
        
        $famille = new Tag("En famille");
        $manager->persist($famille);

        $manager->flush();
    }
}