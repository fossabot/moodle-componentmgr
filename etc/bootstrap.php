<?php

/**
 * Moodle component manager.
 *
 * @author Luke Carrier <luke@carrier.im>
 * @copyright 2016 Luke Carrier
 * @license GPL-3.0+
 */

use ComponentManager\DependencyInjection\ConsoleCommandsPass;
use Symfony\Bundle\MonologBundle\DependencyInjection\Compiler\LoggerChannelPass;
use Symfony\Bundle\MonologBundle\DependencyInjection\MonologExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

// Error reporting
ini_set('display_errors',  'on');
ini_set('error_reporting', E_ALL);

// Set the default timezone if not already set
if (!ini_get('date.timezone')) {
    date_default_timezone_set(@date_default_timezone_get());
}

$container = new ContainerBuilder();
$container->addCompilerPass(new ConsoleCommandsPass());
$container->setParameter('platform.name', PHP_OS);

$container->registerExtension(new MonologExtension());
$container->addCompilerPass(new LoggerChannelPass());

$loader = new YamlFileLoader($container, new FileLocator(CM_ETC));
$loader->load('services.yml');

$container->compile();
return $container;
