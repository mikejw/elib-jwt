<?php

namespace Empathy\ELib\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use Empathy\ELib\Config;
use Empathy\MVC\DI;
use Empathy\MVC\RequestException;


class Service
{
    private $secret;

    public function __construct()
    {
        if (($this->secret = Config::get('JWT_SECRET')) === false) {
            throw new \Exception('No secret provided. Add to "elib.yml"');
        }
    }

	public function generate()
    {
        $user = DI::getContainer()->get('CurrentUser')->getUser();
        $token = array();
        $token['user_id'] = $user->id;
        $jwt = JWT::encode($token, $this->secret, 'HS256');
        return $jwt;
    }

    public function tryAuthenticate ()
    {
        $token = null;
        $request_headers = apache_request_headers();
        $auth_header = '';

        if (isset($request_headers['Authorization'])) {
            $auth_header = $request_headers['Authorization'];
        } elseif (isset($request_headers['authorization'])) {
            $auth_header = $request_headers['authorization'];
        }
        if ($auth_header) {
            if (preg_match('#Bearer\s(\S+)#', $auth_header, $matches)) {
                $bearer = $matches[1];
            }
            if ($bearer) {
                try {
                    $token = JWT::decode($bearer, new Key($this->secret, 'HS256')); 
                } catch (Exception $e) {
                    throw new RequestException('Not authenticated', RequestException::NOT_AUTHENTICATED);
                }
            }
        }
        return $token;
    }
}
