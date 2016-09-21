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
            case 'load-components':
                $this->loadComponents();
                break;
            case 'load-curso-capacitacion':
                $this->loadCursoCapacitacion();
                break;
            case 'load-pais':
                $this->loadPais();
                break;
            case 'load-provincia':
                $this->loadProvincia();
                break;
            case 'load-ciudad':
                $this->loadCiudad();
                break;
            case 'load-person-by-document':
                $this->loadPersonByDocument();
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
    
    private function loadComponents ()
    {
        $resAjax = new Response_Ajax();
        
        $arrType = array('TIPO_IDENT','ESTADO_CIVIL','GENDER', 'TIPO_DE_SANGRE','DISCAPACIDAD','NIVEL_ACADEMICO');
        
        try
        {
            $oBus = Business_App_Catalog::listByType($arrType);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $dataCatalogo = $oBus->data();
            $eCatalogs = $dataCatalogo['eCatalogs'];
            
            $oBus1 = Business_App_Curso_Capacitacion_Sede::listSede('', NULL, NULL);
            
            $dataSede = $oBus1->data();
            $eSedes = $dataSede['eSedes'];
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(array('eCatalogs'=>$eCatalogs, 'eSedes'=>$eSedes));
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadPais()
    {
        $resAjax = new Response_Ajax();
        try
        {
            $oBus = Business_App_Pais::listPais($ePaises/*REF*/);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $combo_pais = Helper_Array::entitiesToIdText($ePaises, 'id', 'nombre', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'cbo-pais' => $combo_pais
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadProvincia()
    {
        $resAjax = new Response_Ajax();
        
        $id_pais = $this->input->post('id_pais');
        
        try
        {
            $oBus = Business_App_Provincia::listProvincia($id_pais, $eProvincias/*REF*/);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $combo_provincia = Helper_Array::entitiesToIdText($eProvincias, 'id', 'nombre', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'cbo-provincia' => $combo_provincia
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadCiudad()
    {
        $resAjax = new Response_Ajax();
        
        $id_provincia = $this->input->post('id_provincia');
        
        try
        {
            $oBus = Business_App_Ciudad::listCiudad($id_provincia, $eCiudades/*REF*/);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $combo_ciudad = Helper_Array::entitiesToIdText($eCiudades, 'id', 'nombre', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'cbo-ciudad' => $combo_ciudad
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadPersonByDocument()
    {
        $this->load->file('application/modules/app/venta_cfae/form/venta_cfae_form.php');
        
        $frm_data = new Form_App_Venta_Cfae();
        
        $resAjax = new Response_Ajax();
        
        $document = $this->input->post('document');
        try 
        {
            
            //PERSON
            $oBusPerson = Business_App_Person::loadByDocument($document);

            if(!$oBusPerson->isSuccess())
            {
                throw new Exception($oBusPerson->message());
            }
            
            $dataPerson = $oBusPerson->data();

            /* @var $ePerson ePerson  */
            $ePerson   = $dataPerson['ePerson'];
            
            $frm_data->setPersonEntity($ePerson);
            
            
            $resAjax->isSuccess( TRUE );
        }
        catch (Exception $exc)
        {
            $resAjax->isSuccess( FALSE );
            $resAjax->message( $exc->getMessage() );
        }
        
        $resAjax->form('person', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
}