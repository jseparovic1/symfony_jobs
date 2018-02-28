<?php

use MsgPhp\User\Entity\User;
use MsgPhp\User\Entity\UserRole;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container->parameters()
        ->set('msgphp.default_data_type', 'uuid');

    $container->extension('msgphp_user', [
        'class_mapping' => [
            User::class => \App\Entity\User::class,
            UserRole::class => \App\Entity\UserRole::class,
        ],
    ]);
};