<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 7/23/17
 * Time: 11:51 PM
 */

namespace AppBundle\Repository;


class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOnlyUser(){

        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('AppBundle:User', 'u')
            ->where('u.isValid = 1')
            ->getQuery()->getResult()
            ;
    }

    public function findSingle($id){

        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('AppBundle:User', 'u')
            ->leftJoin('u.regions', 'r')->addSelect('r')
            ->leftJoin('u.types', 't')->addSelect('t')
            ->where('u.id = :uId')
            ->setParameter('uId', $id)
            ->getQuery()->getResult()

            ;
    }
}