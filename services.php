<?php

use Empathy\ELib\JWT\Service;


return [
    'JWT' => function (\DI\Container $c) {
        return new Service();
    }
];
