<?php

use App\Kernel;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput as ConsoleOutput;

$file = __DIR__.'/../vendor/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies using Composer to run the test suite.');
}

$autoload = require $file;
AnnotationRegistry::registerLoader(function ($class) use ($autoload) {
    $autoload->loadClass($class);
    return class_exists($class, false);
});


$application = new Application(new Kernel('test', true));
$application->setAutoExit(false);

// Drop database
$input = new ArrayInput([
    'command' => 'doctrine:database:drop'
]);
$application->run($input, new ConsoleOutput());

// Create database
$input = new ArrayInput([
    'command' => 'doctrine:database:create'
]);
$application->run($input, new ConsoleOutput());

// Create database schema
$input = new ArrayInput([
    'command' => 'doctrine:schema:create'
]);
$application->run($input, new ConsoleOutput());

// Load fixtures of the AppTestBundle
//$input = new ArrayInput(['command' => 'doctrine:fixtures:load', '--no-interaction' => true, '--append' => false]);
//$application->run($input, new ConsoleOutput());

unset($input, $application);