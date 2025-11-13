<?php

namespace Empathy\ELib\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use Empathy\ELib\Config;
use Empathy\MVC\DI;
use Empathy\MVC\RequestException;
use Empathy\MVC\Config as EConfig;


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
        $now = time();
        $ttl = 3600;
        $iss = (\Empathy\MVC\Util\Misc::isSecure() ? 'https' : 'http') . '://' . EConfig::get('WEB_ROOT');
        $aud = str_replace('/', '-', EConfig::get('NAME'));

        $user = DI::getContainer()->get('CurrentUser')->getUser();
        $payload = [
            'sub' => (string)$user->id,
            'iss' => $iss,
            'aud' => $aud,
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + $ttl,
            'user_id' => (int)$user->id
        ];
        $jwt = JWT::encode($payload, $this->secret, 'HS256');
        return $jwt;
    }

    public function tryAuthenticate($bearer = '')
    {
        $token = null;
        $auth_header = '';

        if (!$bearer) {
            $request_headers = apache_request_headers();

            if (isset($request_headers['Authorization'])) {
                $auth_header = $request_headers['Authorization'];
            } elseif (isset($request_headers['authorization'])) {
                $auth_header = $request_headers['authorization'];
            }
            if ($auth_header) {
                if (preg_match('#Bearer\s(\S+)#', $auth_header, $matches)) {
                    $bearer = $matches[1];
                }
            }
        }
        if ($bearer) {
            try {
                $token = JWT::decode($bearer, new Key($this->secret, 'HS256'));
            } catch (Exception $e) {
                throw new RequestException('Not authenticated', RequestException::NOT_AUTHENTICATED);
            }
        }
        return $token;
    }
}
