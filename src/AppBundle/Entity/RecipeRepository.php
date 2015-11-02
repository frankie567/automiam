<?php

namespace AppBundle\Entity;

/**
 * RecipeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecipeRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchRecipes($user, $categoryId, $tags)
    {
        $queryBuilder = $this->createQueryBuilder('r');
        
        $queryBuilder->leftJoin('r.user', 'user');
        $queryBuilder->where('user.id = :userId');
        $queryBuilder->setParameter(':userId', $user->getId());
        
        $queryBuilder->leftJoin('r.category', 'category');
        $queryBuilder->andWhere('category.id = :categoryId');
        $queryBuilder->setParameter(':categoryId', $categoryId);
        
        $queryBuilder->leftJoin('r.tags', 't');
        $queryBuilder->andWhere('t.id IN(:tags)');
        $queryBuilder->setParameter(':tags', array_values($tags->toArray()));
        
        $queryBuilder->having('COUNT(t) >= :nbTags');
        $queryBuilder->setParameter('nbTags', count($tags));
        
        $queryBuilder->add('groupBy', 'r.id');

        return $queryBuilder->getQuery()->getResult();
    }
}
