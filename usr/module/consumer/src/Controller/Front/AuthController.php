<?php
namespace Module\Consumer\Controller\Front;
use Pi;
use Pi\Mvc\Controller\ActionController;


class AuthController extends ActionController
{

    /**
    * 发起授权服务请求，
    */
    public function indexAction()
    {
        $oauth = Pi::service('api')->consumer(array('server','getserver'),$this->config());
        // $oauth->getAuthorizeURL($this->config('callback'));
        $url = $oauth->getAuthorizeURL('pi-oauth.com/consumer/auth/callback');
        $this->redirect()->toUrl($url);
        $this->view()->setTemplate(false);
    }

    /**
    * 授权服务回调函数，使用授权码换取token
    *
    * @param code ：必须  授权码服务返回的授权码
    * @param state：可选  请求和回调的状态字符串
    * @param next： 可选  token获取后，浏览器的导向地址，默认跳转到当前域名地址
    * @return 如果请求token过程出现错误，则显示错误信息页面；否则跳转到后续页面
    */
    public function callbackAction()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $code = $this->params('code','');
        $state = $this->params('state','');
        $next = $this->params('next', '');

        if (isset($_SESSION['state'])) {
            if ($state != $_SESSION['state']) {
                return false;
            }
            unset($_SESSION['state']);
        }
        
        if (!$code) {
            $token['error'] = 'missing code';
        } else {
            $oauth = Pi::service('api')->consumer(array('server','getserver'),$this->config());
            // $oauth->getAccessToken('code',array('code' => $code, 'redirect_uri' => $this->config('callback'));
            $redirect_uri = $this->request->getServer('HTTP_HOST').$this->request->getServer('REDIRECT_URL');
            $token = $oauth->getAccessToken('code',array('code' => $code, 'redirect_uri' => $redirect_uri));
        }
        if (!isset($token['error'])) {
            $this->view()->assign('url', $next);
            $this->view()->setTemplate('callback-jump');
        } else {
            $this->view()->assign('error',$token);
            $this->view()->setTemplate('callback-error');
        }
        
    }

    
    public function tokenAction()
    {
        // $token = $this->getToken();var_dump($token);
        // var_dump($_SESSION);
        // if (!$token) {
        //  return false;
        // }
        echo "<pre>";
        var_dump($_SESSION);
        unset($_SESSION['token']);
        // echo $this->request->getServer('HTTP_HOST').$this->request->getServer('REDIRECT_URL');
    }
}
