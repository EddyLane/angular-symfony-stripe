<?php

namespace Acceptance\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\CommonContexts\WebApiContext;

/**
 * Features context.
 */
class MainContext extends BehatContext implements KernelAwareInterface
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('web_api', new WebApiContext($parameters['base_url']));
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
     * @return mixed
     */
    public function getMink()
    {
        return $this->getSubcontext('mink')->getMink();
    }

    /**
     * @return \Behat\Behat\Context\ExtendedContextInterface
     */
    public function getWebApi()
    {
        return $this->getSubcontext('web_api');
    }

}