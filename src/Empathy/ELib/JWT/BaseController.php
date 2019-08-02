<?php


namespace Empathy\ELib\JWT;
use Empathy\MVC\Controller as Controller;
use Empathy\MVC\Config;
use Exception;
use Firebase\JWT\JWT;

/**
 * Empathy JWT Plugin Controller
 * @file            Empathy/ELib/JWT/BaseController.php
 * @description
 * @author          Mike Whiting
 * @license         See LICENCE
 *
 * (c) copyright Mike Whiting

 * with this source code in the file licence.txt
 */
class BaseController extends Controller
{

    public function __construct($boot)
    {
        parent::__construct($boot);

        $plugin = \Empathy\MVC\DI::getContainer()->get('Empathy\\ELib\\JWT\\Plugin');
        $config = $plugin->getConfig();

        if (
            $this->module == $config['auth_module'] &&
            $this->class == $config['auth_class'] &&
            $this->event == $config['auth_method']
        ) {
            $this->auth();
        } else {
            $this->info();
        }

    }

    private function auth() {
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Accept, Authorization, X-Request-With');
        header('Content-type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $JWT_token = 'non_authorized';

        if (isset($data["pass"]) && isset($data["username"])) {
            if ($data["pass"] == "demo" and $data["username"] == "demo") {
                $token = array();
                $token['id'] = '123';
                $JWT_token = JWT::encode($token, 'secret_server_key');
            }
        }
        echo json_encode(array('access_token' => $JWT_token));
        return false;
    }

    private function info() {
        header('Access-Control-Allow-Origin: http://127.0.0.1:4200');
        header('Access-Control-Allow-Headers: Origin, Content-Type,Accept,Authorization ');
        header('Content-type: application/json');

        $request_headers = apache_request_headers();
        if (isset($request_headers['Authorization'])) {

            $auth_header = $request_headers['Authorization'];
            if ($auth_header
                &&
                preg_match('#Bearer\s(\S+)#', $auth_header, $matches)) {
                $bearer = $matches[1];
            }

            if ($bearer) {
                try {
                    $token = JWT::decode($bearer, 'secret_server_key', ['HS256']);

                    echo json_encode(array('user_name' => 'admin'));
                } catch (Exception $e) {

                    echo $e->getMessage();
                    //header("HTTP/1.1 401 Unauthorized");
                    exit;
                }
            }
        }
        return false;
    }
}
