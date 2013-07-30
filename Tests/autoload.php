<?php

$vendorDir = __DIR__.'/../vendor';

//composer autoload file
if (file_exists($vendorDir.'/autoload.php')) {
    require_once $vendorDir.'/autoload.php';

    return;
}

require_once $vendorDir.'/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'           => $vendorDir.'/symfony/src',
    'Assetic'           => $vendorDir.'/src',
    'Doctrine\Common'   => $vendorDir.'/doctrine-common/lib',
    'Doctrine\DBAL'     => $vendorDir.'/../vendor/doctrine-dbal/lib',
    'Doctrine\Tests'    => $vendorDir.'/doctrine/tests',
    'Doctrine'          => $vendorDir.'/doctrine/lib',
));
$loader->registerPrefixes(array(
    'Twig_'             => array($vendorDir.'/twig/lib', $vendorDir.'/twig-extensions/lib'),
));
$loader->register();

spl_autoload_register(function($class) {
    if (0 === strpos($class, 'Avocode\\FormExtensionsBundle\\')) {
        $path = __DIR__.'/../'.implode('/', array_slice(explode('\\', $class), 2)).'.php';
        if (!stream_resolve_include_path($path)) {
            return false;
        }
        require_once $path;

        return true;
    }
});
