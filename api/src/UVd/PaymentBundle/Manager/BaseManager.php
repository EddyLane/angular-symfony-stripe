<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edwardlane
 * Date: 16/11/2013
 * Time: 14:16
 * To change this template use File | Settings | File Templates.
 */

namespace UVd\PaymentBundle\Manager;

use Symfony\Component\Security\Core\SecurityContext;

class BaseManager implements ManagerInterface
{
    /**
     * @param string $className
     */
    protected $className;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext $securityContext
     */
    protected $securityContext;

    /**
     * This allows the manager to use a different repository
     *
     * @param \Doctrine\ORM\EntityRepository $repository
     */
    protected $repository = null;

    /**
     * @param $className
     */
    public function __construct($className)
    {
        $this->setClassName($className);
    }

    /**
     * @param $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @param SecurityContext $context
     */
    public function setSecurityContext(SecurityContext $context)
    {
        $this->securityContext = $context;
    }

    /**
     * @return null
     */
    public function getRepository()
    {
        if( $this->repository == null) {
            return $this->getEntityManager()->getRepository($this->className);
        }else {
            return $this->repository;
        }
    }

    /**
     * @param null $constructWith
     * @return mixed
     */
    public function create($constructWith = null)
    {
        if(!is_null($constructWith)){
            return new $this->className($constructWith);
        }

        return new $this->className();
    }

    /**
     * @param $entity
     * @param bool $flush
     */
    public function save($entity, $flush = true)
    {
        $this->isClassValid($entity);

        $this->getEntityManager()->persist($entity);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param $entity
     * @param bool $flush
     */
    public function remove($entity, $flush = true)
    {
        $this->isClassValid($entity);

        $this->getEntityManager()->remove($entity);

        if ($flush === true) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     *
     */
    public function clear()
    {
        $this->getEntityManager()->clear();
    }

    /**
     * @param $entity
     */
    public function merge($entity)
    {
        $this->isClassValid($entity);

        $this->getEntityManager()->merge($entity);
    }

    /**
     * @param $entity
     * @return bool
     * @throws \Exception
     */
    protected function isClassValid($entity)
    {
        if ($entity instanceof $this->className || is_subclass_of($entity, $this->className)) {
            return true;
        }

        throw new \Exception('Factory does not manage that class');
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->doctrine->getManager();
    }

    /**
     * @param $doctrine
     */
    public function setDoctrine($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return mixed
     */
    public function getCacheDriver()
    {
        return $this->getEntityManager()->getConfiguration()->getResultCacheImpl();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

}