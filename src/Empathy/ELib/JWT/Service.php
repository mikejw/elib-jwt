<?php

namespace Empathy\ELib\JWT;
use Firebase\JWT\JWT;
use Empathy\ELib\Config;
use Empathy\MVC\DI;

class Service
{

	public function generate()
    {
        if (($secret = Config::get('JWT_SECRET')) === false) {
            throw new \Exception('No secret provided. Add to "elib.yml"');
        }

        $user = DI::getContainer()->get('CurrentUser')->getUser();
        $token = array();
        $token['id'] = $user->id;
        $jwt = JWT::encode($token, $secret, 'HS256');
        return $jwt;
    }
}