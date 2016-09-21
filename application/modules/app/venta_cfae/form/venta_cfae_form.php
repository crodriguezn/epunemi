<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Venta_Cfae extends MY_Form
{
    //PERSON
    public $id_person;
    public $name;
    public $surname;
    public $tipo_documento;
    public $document;
    public $birthday;
    public $gender;
    public $address;
    public $phone_cell;
    public $email;
    public $estado_civil;
    public $tipo_sangre;
    public $id_ciudad;
    public $id_pais;
    public $id_provincia;
    
    //VENTA CFAE
    public $id_venta_cfae;
    public $estado;
    public $registration_date;
    

    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        //PERSON
        $this->id_user              = 0;
        $this->id_person            = 0;
        $this->name                 = '';
        $this->surname              = '';
        $this->tipo_documento       = 'TIPO_IDENT_CEDULA';
        $this->document             = '';
        $this->birthday             = '';
        $this->gender               = 'GENDER_MALE';
        $this->address              = '';
        $this->phone_cell           = '';
        $this->email                = '';
        $this->estado_civil         = 'ESTADO_CIVIL_SOLTERO';
        $this->tipo_sangre          = 'TIPO_SANGRE_A+';
        $this->id_provincia         = 1558;
        $this->id_pais              = 70;
        $this->id_ciudad            = 47949;
        
        //VENTA CFAE
        $this->id_venta_cfae        = 0;
        $this->estado               = '';
        $this->registration_date    = '';
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        //PERSON
        $this->id_person            = $MY->input->post('id_person');
        $this->name                 = $MY->input->post('name');
        $this->surname              = $MY->input->post('surname');
        $this->tipo_documento       = $MY->input->post('tipo_documento');
        $this->document             = $MY->input->post('document');
        $this->birthday             = $MY->input->post('birthday');
        $this->gender               = $MY->input->post('gender');
        $this->address              = $MY->input->post('address');
        $this->phone_cell           = $MY->input->post('phone_cell');
        $this->email                = $MY->input->post('email');
        $this->estado_civil         = $MY->input->post('estado_civil');
        $this->tipo_sangre          = $MY->input->post('tipo_sangre');
        $this->id_ciudad            = $MY->input->post('id_ciudad');
        
        //VENTA CFAE
        $this->id_venta_cfae        = $MY->input->post('id_venta_cfae');
        $this->registration_date    = $MY->input->post('registration_date');
        $this->estado               = $MY->input->post('estado');
        
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        //PERSON
        if( empty($this->name) )
        {
            $this->addError('name', 'Campo no debe estar vacío');
        }
        
        if( empty($this->surname) )
        {
            $this->addError('surname', 'Campo no debe estar vacío');
        }    
        
        if( empty($this->tipo_documento) )
        {
            $this->addError('tipo_documento', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->document) )
        {
            $this->addError('document', 'Campo no debe estar vacío');
        }  
        
        if (empty($this->birthday)) 
        {
            $this->addError('birthday', 'Campo no debe estar vacío');
        }
        else
        {
            if(Helper_Fecha::validar_fecha($this->birthday) === false)
            {
                $this->addError('birthday', 'Ingrese una fecha válida');
            }
        }
        
        if( empty($this->gender) )
        {
            $this->addError('gender', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->address) )
        {
            $this->addError('address', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->email) )
        {
            $this->addError('email', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->estado_civil) )
        {
            $this->addError('estado_civil', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->tipo_sangre) )
        {
            $this->addError('tipo_sangre', 'Campo no debe estar vacío');
        }  
        
        return $this->isErrorEmpty();
    }
    
    //PERSON
    public function getPersonEntity()
    {
        $ePerson = new ePerson(FALSE);
        
        $ePerson->id                = $this->id_person;
        $ePerson->name              = $this->name;
        $ePerson->surname           = $this->surname;
        $ePerson->tipo_documento    = $this->tipo_documento;
        $ePerson->document          = $this->document;
        $ePerson->birthday          = $this->birthday;
        $ePerson->gender            = $this->gender;
        $ePerson->address           = $this->address;
        $ePerson->phone_cell        = $this->phone_cell;
        $ePerson->email             = $this->email;
        $ePerson->estado_civil      = $this->estado_civil;
        $ePerson->tipo_sangre       = $this->tipo_sangre;
        $ePerson->id_ciudad         = empty($this->id_ciudad) ? NULL : $this->id_ciudad ;
        
        return $ePerson;
    }
    
    public function setPersonEntity(ePerson $ePerson )
    {
        $this->id_person        = empty($ePerson->id) ? 0 : $ePerson->id;
        $this->name             = $ePerson->name;
        $this->surname          = $ePerson->surname;
        if(!empty($ePerson->tipo_documento)) { $this->tipo_documento   = $ePerson->tipo_documento; }
        
        $this->document         = $ePerson->document;
        $this->birthday         = $ePerson->birthday;
        
        if(!empty($ePerson->gender)) { $this->gender   = $ePerson->gender; }

        $this->address          = $ePerson->address;
        $this->phone_cell       = $ePerson->phone_cell;
        $this->email            = $ePerson->email;
        
        if(!empty($ePerson->estado_civil)) { $this->estado_civil   = $ePerson->estado_civil; }
        if(!empty($ePerson->tipo_sangre)) { $this->tipo_sangre   = $ePerson->tipo_sangre; }
        $this->id_ciudad        = $ePerson->id_ciudad;
    }   
       
    //VEENTA
    public function getVentaCFAEEntity()
    {
        $eSaleControl = new eSaleControl(FALSE);
        
        $eSaleControl->id_person                = empty($this->id_person) ? 0 : $this->id_person ;
        $eSaleControl->registration_date        = empty($this->registration_date) ? date('Y-m-d H:i:s') : $this->registration_date ;
        $eSaleControl->estado                   = $this->estado;
        
        return $eSaleControl;
    }

    public function setVentaCFAEEntity(eSaleControl $eSaleControl )
    {
        $this->id_venta_cfae            = empty($eSaleControl->id) ? 0 : $eSaleControl->id ;
        $this->registration_date        = empty($this->registration_date) ? date('Y-m-d H:i:s') : $this->registration_date ;
        $this->estado                   = $eSaleControl->estado;
    }
    
}
