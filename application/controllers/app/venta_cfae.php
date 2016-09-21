<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venta_Cfae extends MY_Controller
{
    protected $name_key = 'venta_cfae';
    
    /* @var $permission Venta_Cfae_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/venta_cfae/permission.php');
        $this->permission = new Venta_Cfae_Permission( $this->name_key );
        
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
        
        if( !$this->permission->access )
        {
            Helper_App_Log::write("My Profile: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        Helper_App_View::layout('app/html/pages/venta/cfae/page');
    }
    
    public function mvcjs()
    {
        
        $this->load->file('application/modules/app/venta_cfae/form/venta_cfae_form.php');
        $frmVentaCfae = new Form_App_Venta_Cfae();
        
        /*$oBus = Business_App_User::loadUser( Helper_App_Session::getUserId() );
        $data = $oBus->data();
        $eUser = $data['eUser'];
        
        $frmUser->username = $eUser->username;*/
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'venta_cfae_form_default' => $frmVentaCfae->toArray()
        );
        
        Helper_App_JS::showMVC('venta/cfae', $params);
    }
}