<?php

namespace Module\Oauth\Form;

use Pi;
use Pi\Form\Form as BaseForm;
use Zend\Form\Zend\Form\Form;
use Zend\Form\Element;


class ClientRegisterForm extends BaseForm
{
    public function init() 
    {
        $this->add(array(
            'name'          => 'clientname',
            'options'       => array(
                'label' => __('input your name'),
            ),
            'attributes'    => array(
                'type'  => 'text',
            )
        ));

        $this->add(array(
            'name'          => 'redirect_uri',
            'options'       => array(
                'label' => __('your address'),
            ),
            'attributes'    => array(
                'type'  => 'text',
            )
        ));

        $this->add(array(
            'name'          => 'clienttype',
            'options'       => array(
                'label' => __('应用类型'),
            ),
            'attributes'    => array(
                'type'  => 'select',
                'options' => array(
                    'authorizecode' => '网站应用',
                    'appcode' => '移动应用',
                ),
            )
        ));

        $this->add(array(
            'name'          => 'submit',
            'attributes'    => array(
                'value'     => __('submit'),
            ),
            'type'          => 'submit',
        ));
    } 
}