<?php

namespace Acceptance\Context\Data;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\Query;

/**
 * Data context.
 */
class DataContext extends BehatContext implements KernelAwareInterface
{
    protected $loader;
    protected $executor;
    protected $parameters;

    protected $kernel;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Gets the kernel
     *
     * @return KernelInterface
     */
    public function getKernel()
    {
        return $this->kernel;
    }
    /**
     * Gets an entity manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this
            ->getKernel()
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ;
    }

    /**
     * Empty the payment table
     */
    protected function removeAllPayments()
    {
        $em = $this->getEntityManager();

        $em
            ->createQuery('DELETE UVdPaymentBundle:Payment')
            ->execute()
        ;
        $em
            ->getConnection()
            ->exec("ALTER TABLE payment AUTO_INCREMENT = 1; ")

        ;
        $em->flush();
    }

    /**
     * @return array
     */
    protected function getAllPayments()
    {
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from('UVdPaymentBundle:Payment', 'p')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    /**
     * @Given /^no payments exist in the system$/
     */
    public function noPaymentsExistInTheSystem()
    {
        $this->removeAllPayments();
    }

    /**
     * @Given /^only the following payments should now exist in the system:$/
     */
    public function onlyTheFollowingPaymentsShouldNowExistInTheSystem(TableNode $expected)
    {
        $actual = $this->getAllPayments();
        $expected = $expected->getHash();
        assertEquals($expected, $actual);
    }

}