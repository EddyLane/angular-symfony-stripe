<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 19/12/2013
 * Time: 21:40
 */

namespace UVd\SubscriptionBundle\DataFixtures\ORM;

use UVd\SubscriptionBundle\DataFixtures\ORM as BaseLoader;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Nelmio\Alice\Fixtures;


abstract class Loader implements FixtureInterface
{
    const SRC_DIR = '/../../../../';
    const FIXTURE_DIR = '/../';

    /**
     * @param array $fixtures
     * @param ObjectManager $manager
     */
    protected function loadFixtures(array $fixtures, ObjectManager $manager)
    {
        foreach($fixtures as $i => $fixture) {
            $fixtures[$i] = $this->replaceFixtureFilePath($fixture);
        }
        Fixtures::load($fixtures, $manager);
    }

    /**
     * Converts a filename to a path with filename
     *
     * @param type $filename
     * @return string $path
     * @throws FileNotFoundException
     */
    protected function replaceFixtureFilePath($filename)
    {
        $path = sprintf(__DIR__ . self::SRC_DIR . '/%s', $filename);
        if (!file_exists($path)) {
            throw new FileNotFoundException($path);
        }
        return $path;
    }
}