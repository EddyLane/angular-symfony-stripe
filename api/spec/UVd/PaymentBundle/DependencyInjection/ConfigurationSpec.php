<?php

namespace spec\UVd\PaymentBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\DependencyInjection\Configuration');
    }

    function it_should_set_the_tree_builder_config()
    {
        $this
            ->getConfigTreeBuilder()
            ->shouldReturnAnInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder')
        ;
    }
}
