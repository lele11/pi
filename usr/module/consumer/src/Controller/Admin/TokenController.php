<?php
namespace Module\Consumer\Controller\Admin;

use Pi;
use Pi\Mvc\Controller\ActionController;

class TokenController extends ActionController
{
    public function indexAction()
    {
        $this->view()->setTemplate(false);
    }
}