<?php

declare(strict_types=1);

namespace ProxyManager\ProxyGenerator;

use ReflectionClass;
use Zend\Code\Generator\ClassGenerator;

/**
 * Base interface for proxy generators - describes how a proxy generator should use
 * reflection classes to modify given class generators
 */
interface ProxyGeneratorInterface
{
    /**
     * Apply modifications to the provided $classGenerator to proxy logic from $originalClass
     *
     * @return void
     */
    public function generate(ReflectionClass $originalClass, ClassGenerator $classGenerator);
}
