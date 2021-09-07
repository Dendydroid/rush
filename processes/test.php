<?php

use App\Component\Data\Entities\Client;

require "setup.php";

$reflect = new \ReflectionClass(Client::class);
foreach ($reflect->getProperties() as $property) {
    dump($property->getType()->getName());
    dump($property->getName());
//            switch ($property->getType()) {
//
//            }
}