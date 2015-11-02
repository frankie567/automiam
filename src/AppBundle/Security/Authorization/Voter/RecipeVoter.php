<?php
namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class RecipeVoter extends AbstractVoter
{
    const EDIT = 'edit';

    protected function getSupportedAttributes()
    {
        return array(self::EDIT);
    }

    protected function getSupportedClasses()
    {
        return array('AppBundle\Entity\Recipe');
    }

    protected function isGranted($attribute, $recipe, $user = null)
    {
        // make sure there is a user object (i.e. that the user is logged in)
        if (!$user instanceof UserInterface)
        {
            return false;
        }

        // double-check that the User object is the expected entity (this
        // only happens when you did not configure the security system properly)
        if (!$user instanceof User)
        {
            throw new \LogicException('The user is somehow not our User class!');
        }

        switch($attribute)
        {
            case self::EDIT:
                // this assumes that the data object has a getOwner() method
                // to get the entity of the user who owns this data object
                if ($user->getId() === $recipe->getUser()->getId())
                {
                    return true;
                }

                break;
        }

        return false;
    }
}