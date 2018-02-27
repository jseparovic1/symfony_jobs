<?php

namespace App\Controller;

use App\Command\ExampleCommand;

class HomeController extends BaseAction
{
    public function index() {

        $this->bus->handle(new ExampleCommand('', 'user@sex.com'));

        $data = [
            "data" => "data",
        ];

        return $this->createView($data);
    }
}
