<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edwardlane
 * Date: 16/11/2013
 * Time: 14:16
 * To change this template use File | Settings | File Templates.
 */

namespace UVd\PaymentBundle\Manager;

use Doctrine\ORM\NonUniqueResultException;

class BaseManager implements ManagerInterface
{
    /**
     * @param string $className
     */
    protected $className;

    /**
     * @param Doctrine\ORM\EntityRepository $repository
     * this allows the manager to use a different repository
     * to the one specified by the doctrine em
     */
    protected $repository = null;

    public function __construct($className)
    {
        $this->setClassName($className);
    }

    public function setClassName($className)
    {
        $this->className = $className;
    }

    // should really be protected...
    public function getRepository()
    {
        if( $this->repository == null) {
            return $this->getEntityManager()->getRepository($this->className);
        }else {
            return $this->repository;
        }
    }

    public function create($constructWith = null)
    {
        if( $constructWith !== null){
            return new $this->className($constructWith);
        }

        return new $this->className();
    }

    public function save($entity, $flush = true)
    {
        $this->isClassValid($entity);

        $this->getEntityManager()->persist($entity);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove($entity, $flush = true)
    {
        $this->isClassValid($entity);

        $this->getEntityManager()->remove($entity);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }
    }

    public function clear()
    {
        $this->getEntityManager()->clear();
    }

    public function merge($entity)
    {
        $this->isClassValid($entity);

        $this->getEntityManager()->merge($entity);
    }

    protected function isClassValid($entity)
    {
        if ($entity instanceof $this->className || is_subclass_of($entity, $this->className)) {
            return true;
        }

        throw new \Exception('Factory does not manage that class');
    }

    public function getEntityManager()
    {
        return $this->doctrine->getManager();
    }

    public function setDoctrine($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getCacheDriver()
    {
        return $this->getEntityManager()->getConfiguration()->getResultCacheImpl();
    }

    public function find($id)
    {
        return $this->getRepository()->find($id);
    }



    /**
     * findOnyBy finds and caches an entity based on one of its fields
     *
     * @param string $field
     * @param string $value
     *
     * @todo this should be abstract class which the implementations
     *       each validating the field passed in and the caching policy
     */
    public function findOneBy($field = 'id', $value = null)
    {

        //query for many countries by name
        $query = $this
            ->getRepository()
            ->findAllBy($field, $value)
        ;

        //allways cache for now - until we have a requirement not too?!
        $query->useResultCache(true);
        $query->setResultCacheLifetime(3600);

        //this particular method wants a single result
        try {
            $entity = $query->getOneOrNullResult();
        }
        catch(NonUniqueResultException $e) {
            return null;
        }

        return $entity;
    }

    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

}