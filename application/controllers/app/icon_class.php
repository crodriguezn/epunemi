<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Icon_Class extends MY_Controller
{
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );
        
        if( !Helper_App_Session::isLogin() )
        {
            $this->redirect('app/dashboard');
            return;
        }
        
    }

    public function index()
    {
        Helper_App_View::layout('app/html/pages/icon_class/page', [], [], TRUE);
    }
    
    public function modal()
    {
       echo Helper_App_View::view('app/html/pages/icon_class/page', [], TRUE);
    }
}