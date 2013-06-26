<?php
namespace Module\Oauthdemo\Controller\Front;

use Pi;
use Pi\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    
    public function indexAction()
    {
        
        $this->view()->setTemplate('demo-index');
    }

   
