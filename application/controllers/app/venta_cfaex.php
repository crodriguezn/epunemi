<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venta_CfaeX extends MY_Controller
{
    protected $name_key = 'venta_cfae';
    
    /* @var $permission Venta_Cfae_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/venta_cfae/permission.php');
        $this->permission = new Venta_Cfae_Permission( $this->name_key );
        $this->permission->create = Helper_App_Session::isPermissionForModule($this->name_key,'create');
        $this->permission->update = Helper_App_Session::isPermissionForModule($this->name_key,'update');
        
    }

    public function process( $action )
    {
        if( !Helper_App_Session::isLogin() )
        {
            $this->noaction('Fuera de sesión');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->noaction('Fuera de sesión por Inactividad');
            return;
        }
        
        if( Helper_App_Session::isBlock() )
        {
            $this->noaction('Fuera de session por Bloqueo');
            return;
        }
        
        if( !$this->permission->access )
        {
            $this->noaction('Acceso no permitido');
            return;
        }

        switch( $action )
        {
            case 'list-venta-cfae':
                $this->listVentaCFAE();
                break;
            default:
                $this->noaction($action);
                break;
        }
    }
    
    private function noaction($action)
    {
        $resAjax = new Response_Ajax();
        
        $resAjax->isSuccess(FALSE);
        $resAjax->message("No found action: $action");
        
        echo $resAjax->toJsonEncode();
    }
    
    private function listVentaCFAE()
    {
        $resAjax = new Response_Ajax();
        
        $txt_filter = $this->input->get('sSearch');
        $limit      = $this->input->get('iDisplayLength');
        $offset     = $this->input->get('iDisplayStart');
        
        $oBus = Business_App_Venta_Cfae::listVentaCFAE($txt_filter, $limit, $offset);
        $data = $oBus->data();

        $eControlVentas         = $data['eControlVentas'];
        $ePersonas              = $data['ePersonas'];
        $eSedes                 = $data['eSedes'];
        $eCursoCapacitaciones   = $data['eCursoCapacitaciones'];
        $count                  = $data['count'];
        
        $aaData = array();
        
        if( !empty($eControlVentas) )
        {
            /* @var $eControlVenta eControlVenta */
            foreach( $eControlVentas as $num => $eControlVenta )
            {
                $aaData[] = array( 
                    trim($ePersonas[$num]->document), 
                    trim($ePersonas[$num]->surname).' '.trim($ePersonas[$num]->name),
                    trim($eSedes[$num]->name), 
                    trim($eCursoCapacitaciones[$num]->name), 
                    trim($eControlVenta->id) 
                    );
            }
        }

        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
    }     
    
}