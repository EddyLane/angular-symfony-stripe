<?php

namespace spec\UVd\PaymentBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UVdPaymentExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\DependencyInjection\UVdPaymentExtension');
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder
     */
    function it_should_load_the_services($containerBuilder)
    {
        $configs = [];
        $this->load($configs, $containerBuilder);
    }
}
