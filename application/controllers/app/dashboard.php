<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    protected $name_key = 'dashboard';
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        if( !Helper_App_Session::isLogin() )
        {
            $this->redirect('app/login');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->redirect('app/login_advanced');
            return;
        }
               
        if( Helper_App_Session::isBlock() )
        {
            $this->redirect('app/login_advanced');
            return;
        }
    }

    public function index()
    {
        Helper_App_View::layout('app/html/pages/dashboard');
    }
    
    public function mvcjs()
    {
        $js_path = 'dashboard';
        
        $params = array(
        );
        
        Helper_App_JS::showMVC($js_path, $params);
    }
}