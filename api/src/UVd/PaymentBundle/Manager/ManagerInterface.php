<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edwardlane
 * Date: 16/11/2013
 * Time: 14:30
 * To change this template use File | Settings | File Templates.
 */

namespace UVd\PaymentBundle\Manager;


interface ManagerInterface
{
    public function create($constructWith = null);

    public function save($entity, $flush = true);

    public function remove($entity, $flush = true);

    public function getRepository();
}