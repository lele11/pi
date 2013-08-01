<?php
namespace Module\Oauth\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;
use Pi\Oauth\Provider\Service ;
// use Module\Oauth\Form\AuthorizationForm;

class IndexController extends ActionController
{
    public function indexAction()
    {
    	$token =  '031218f95005072724aa6c7a35134173eab84fcc';
	    $data = Pi::service('api')->oauth(array('token', 'checkToken'), $token);
        var_dump($data);
    }
}