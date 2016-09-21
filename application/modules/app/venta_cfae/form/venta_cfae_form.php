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
    public $estado_civil;
    public $email;
    public $nivel_academico;
    public $discapacidad;
    public $id_pais;
    public $id_provincia;
    public $id_ciudad;
    public $calle_principal;
    public $calle_secundaria;
    public $referencia_domicilio;
    public $num_casa;
    public $telefono_casa;
    public $telefono_trabajo;
    public $telefono_cell_1;
    public $telefono_cell_2;
    public $email_trabajo;
    public $email_alterno;
    public $ref_1_surname_name;
    public $ref_1_direccion;
    public $ref_1_tlfo_fijo_cell;
    public $ref_1_parentesco;
    public $ref_2_surname_name;
    public $ref_2_direccion;
    public $ref_2_tlfo_fijo_cell;
    public $ref_2_parentesco;
    public $tipo_sangre;
    public $id_nationality;
    public $lugar_trabajo;
    
    //ALUMNO
    public $id_alumno;
    public $registration_date_alumno;
    public $estado_alumno;
    public $estado_date_alumno;


    //VENTA CFAE
    public $id_venta_cfae;
    public $estado_cfae;
    public $registration_date_cfae;
    public $id_employee;
    public $estado_date_cfae;
    public $id_sede;
    public $id_curso_capacitacion;
    public $promocion_curso;
    

    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        //PERSON
        $this->id_person                    = 0;
        $this->name                         = '';
        $this->surname                      = '';
        $this->tipo_documento               = 'TIPO_IDENT_CEDULA';  
        $this->document                     = '';
        $this->birthday                     = '';
        $this->gender                       = 'GENDER_MALE';
        $this->estado_civil                 = 'ESTADO_CIVIL_SOLTERO';
        $this->email                        = '';
        $this->nivel_academico              = 'NIVEL_SECUNDARIA';
        $this->discapacidad                 = 'DISC_NINGUNA';
        $this->id_provincia                 = 1558;
        $this->id_pais                      = 70;
        $this->id_ciudad                    = 47949;
        $this->calle_principal              = '';
        $this->calle_secundaria             = '';
        $this->referencia_domicilio         = '';
        $this->num_casa                     = '';
        $this->telefono_casa                = '';
        $this->telefono_trabajo             = '';
        $this->telefono_cell_1              = '';
        $this->telefono_cell_2              = '';
        $this->email_trabajo                = '';
        $this->email_alterno                = '';
        $this->ref_1_surname_name           = '';
        $this->ref_1_direccion              = '';
        $this->ref_1_tlfo_fijo_cell         = '';
        $this->ref_1_parentesco             = '';
        $this->ref_2_surname_name           = '';
        $this->ref_2_direccion              = '';
        $this->ref_2_tlfo_fijo_cell         = '';
        $this->ref_2_parentesco             = '';
        $this->tipo_sangre                  = 'TIPO_SANGRE_A+';
        $this->id_nationality               = 70;
        $this->lugar_trabajo                = '';
        
        //ALUMNO
        $this->id_alumno                    = 0;
        $this->registration_date_alumno     = '';
        $this->estado_alumno                = '';
        $this->estado_date_alumno           = '';
        
        //VENTA CFAE
        $this->id_venta_cfae                = 0;
        $this->estado_cfae                  = '';
        $this->registration_date_cfae       = '';
        $this->id_employee                  = 0;
        $this->estado_date_cfae             = '';
        $this->id_sede                      = 0;
        $this->promocion_curso              = '';
        $this->id_curso_capacitacion        = 0;
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        //PERSON
        $this->id_person                    = $MY->input->post('id_person');
        $this->name                         = $MY->input->post('name');
        $this->surname                      = $MY->input->post('surname');
        $this->tipo_documento               = $MY->input->post('tipo_documento');
        $this->document                     = $MY->input->post('document');
        $this->birthday                     = $MY->input->post('birthday');
        $this->gender                       = $MY->input->post('gender');
        $this->estado_civil                 = $MY->input->post('estado_civil');
        $this->email                        = $MY->input->post('email');
        $this->nivel_academico              = $MY->input->post('nivel_academico');
        $this->discapacidad                 = $MY->input->post('discapacidad');
        $this->id_provincia                 = $MY->input->post('id_provincia');
        $this->id_pais                      = $MY->input->post('id_pais');
        $this->id_ciudad                    = $MY->input->post('id_ciudad');
        $this->calle_principal              = $MY->input->post('calle_principal');
        $this->calle_secundaria             = $MY->input->post('calle_secundaria');
        $this->referencia_domicilio         = $MY->input->post('referencia_domicilio');
        $this->num_casa                     = $MY->input->post('num_casa');
        $this->telefono_casa                = $MY->input->post('telefono_casa');
        $this->telefono_trabajo             = $MY->input->post('telefono_trabajo');
        $this->telefono_cell_1              = $MY->input->post('telefono_cell_1');
        $this->telefono_cell_2              = $MY->input->post('telefono_cell_2');
        $this->email_trabajo                = $MY->input->post('email_trabajo');
        $this->email_alterno                = $MY->input->post('email_alterno');
        $this->ref_1_surname_name           = $MY->input->post('ref_1_surname_name');
        $this->ref_1_direccion              = $MY->input->post('ref_1_direccion');
        $this->ref_1_tlfo_fijo_cell         = $MY->input->post('ref_1_tlfo_fijo_cell');
        $this->ref_1_parentesco             = $MY->input->post('ref_1_parentesco');
        $this->ref_2_surname_name           = $MY->input->post('ref_2_surname_name');
        $this->ref_2_direccion              = $MY->input->post('ref_2_direccion');
        $this->ref_2_tlfo_fijo_cell         = $MY->input->post('ref_2_tlfo_fijo_cell');
        $this->ref_2_parentesco             = $MY->input->post('ref_2_parentesco');
        $this->tipo_sangre                  = $MY->input->post('tipo_sangre');
        $this->id_nationality               = $MY->input->post('id_nationality');
        $this->lugar_trabajo                = $MY->input->post('lugar_trabajo');
        
        //ALUMNO
        $this->id_alumno                    = $MY->input->post('id_alumno');
        $this->registration_date_alumno     = $MY->input->post('registration_date_alumno');
        $this->estado_alumno                = $MY->input->post('estado_alumno');
        $this->estado_date_alumno           = $MY->input->post('estado_date_alumno');
        
        //VENTA CFAE
        $this->id_venta_cfae                = $MY->input->post('id_venta_cfae');
        $this->estado_cfae                  = $MY->input->post('estado_cfae');
        $this->registration_date_cfae       = $MY->input->post('registration_date_cfae');
        $this->id_employee                  = $MY->input->post('id_employee');
        $this->estado_date_cfae             = $MY->input->post('estado_date_cfae');
        $this->id_sede                      = $MY->input->post('id_sede');
        $this->promocion_curso              = $MY->input->post('promocion_curso');
        
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
        
        $ePerson->id                        = $this->id_person;
        $ePerson->name                      = $this->name;
        $ePerson->surname                   = $this->surname;
        $ePerson->tipo_documento            = $this->tipo_documento;
        $ePerson->document                  = $this->document;
        $ePerson->birthday                  = $this->birthday;
        $ePerson->gender                    = $this->gender;
        $ePerson->estado_civil              = $this->estado_civil;
        $ePerson->email                     = $this->email;
        $ePerson->nivel_academico           = $this->nivel_academico;
        $ePerson->discapacidad              = $this->discapacidad;
        $ePerson->id_ciudad                 = empty($this->id_ciudad) ? NULL : $this->id_ciudad ;
        $ePerson->calle_principal           = $this->calle_principal;
        $ePerson->calle_secundaria          = $this->calle_secundaria;
        $ePerson->referencia_domicilio      = $this->referencia_domicilio;
        $ePerson->num_casa                  = $this->num_casa;
        $ePerson->telefono_casa             = $this->telefono_casa;
        $ePerson->telefono_trabajo          = $this->telefono_trabajo;
        $ePerson->telefono_cell_1           = $this->telefono_cell_1;
        $ePerson->telefono_cell_2           = $this->telefono_cell_2;
        $ePerson->email_trabajo             = $this->email_trabajo;
        $ePerson->email_alterno             = $this->email_alterno;
        $ePerson->ref_1_surname_name        = $this->ref_1_surname_name;
        $ePerson->ref_1_direccion           = $this->ref_1_direccion;
        $ePerson->ref_1_tlfo_fijo_cell      = $this->ref_1_tlfo_fijo_cell;
        $ePerson->ref_1_parentesco          = $this->ref_1_parentesco;
        $ePerson->ref_2_surname_name        = $this->ref_2_surname_name;
        $ePerson->ref_2_direccion           = $this->ref_2_direccion;
        $ePerson->ref_2_tlfo_fijo_cell      = $this->ref_2_tlfo_fijo_cell;
        $ePerson->ref_2_parentesco          = $this->ref_2_parentesco;
        $ePerson->tipo_sangre               = $this->tipo_sangre;
        $ePerson->id_nationality            = $this->id_nationality;
        $ePerson->lugar_trabajo             = $this->lugar_trabajo;
        
        return $ePerson;
    }
    
    public function setPersonEntity(ePerson $ePerson )
    {
        
        $this->id_person                    = empty($ePerson->id) ? 0 : $ePerson->id;
        $this->name                         = $ePerson->name;
        $this->surname                      = $ePerson->surname;
        if(!empty($ePerson->tipo_documento)) { $this->tipo_documento   = $ePerson->tipo_documento; }
        $this->document                     = $ePerson->document;
        $this->birthday                     = $ePerson->birthday;
        if(!empty($ePerson->gender)) { $this->gender   = $ePerson->gender; }
        if(!empty($ePerson->estado_civil)) { $this->estado_civil   = $ePerson->estado_civil; }
        $this->email                        = $ePerson->email;
        $this->nivel_academico              = $ePerson->nivel_academico;
        $this->discapacidad                 = $ePerson->discapacidad;
        $this->id_ciudad                    = $ePerson->id_ciudad;
        $this->calle_principal              = $ePerson->calle_principal;
        $this->calle_secundaria             = $ePerson->calle_secundaria;
        $this->referencia_domicilio         = $ePerson->referencia_domicilio;
        $this->num_casa                     = $ePerson->num_casa;
        $this->telefono_casa                = $ePerson->telefono_casa;
        $this->telefono_trabajo             = $ePerson->telefono_trabajo;
        $this->telefono_cell_1              = $ePerson->telefono_cell_1;
        $this->telefono_cell_2              = $ePerson->telefono_cell_2;
        $this->email_trabajo                = $ePerson->email_trabajo;
        $this->email_alterno                = $ePerson->email_alterno;
        $this->ref_1_surname_name           = $ePerson->ref_1_surname_name;
        $this->ref_1_direccion              = $ePerson->ref_1_direccion;
        $this->ref_1_tlfo_fijo_cell         = $ePerson->ref_1_tlfo_fijo_cell;
        $this->ref_1_parentesco             = $ePerson->ref_1_parentesco;
        $this->ref_2_surname_name           = $ePerson->ref_2_surname_name;
        $this->ref_2_direccion              = $ePerson->ref_2_direccion;
        $this->ref_2_tlfo_fijo_cell         = $ePerson->ref_2_tlfo_fijo_cell;
        $this->ref_2_parentesco             = $ePerson->ref_2_parentesco;
        if(!empty($ePerson->tipo_sangre)) { $this->tipo_sangre   = $ePerson->tipo_sangre; }
        $this->id_nationality               = $ePerson->id_nationality;
        $this->lugar_trabajo                = $ePerson->lugar_trabajo;
        
    }   
       
    //ALUMNO
    public function getAlumnoEntity()
    {
        $eAlumno = new eAlumno(FALSE);
        
        $eAlumno->id                = $this->id_alumno;
        $eAlumno->registration_date = empty($this->registration_date_alumno) ? date('Y-m-d H:i:s') : $this->registration_date_alumno ;
        $eAlumno->estado            = $this->estado_alumno;
        $eAlumno->estado_date       = empty($this->estado_date_alumno) ? date('Y-m-d H:i:s') : $this->estado_date_alumno ;
        
        return $eAlumno;
    }

    public function setAlumnoEntity(eAlumno $eAlumno )
    {
        $this->id_alumno                = $eAlumno->id;
        $this->registration_date_alumno = $eAlumno->registration_date;
        $this->estado_alumno            = $eAlumno->estado;
        $this->estado_date_alumno       = $eAlumno->estado_date;
    }
    
    //VEENTA
    public function getVentaCFAEEntity()
    {
        $eControlVenta = new eControlVenta(FALSE);
        
        $eControlVenta->id                      = empty($this->id_venta_cfae) ? 0 : $this->id_venta_cfae ;
        $eControlVenta->estado                  = $this->estado_cfae;
        $eControlVenta->registration_date       = empty($this->registration_date_cfae) ? date('Y-m-d H:i:s') : $this->registration_date_cfae ;
        $eControlVenta->id_employee             = $this->id_employee;
        $eControlVenta->estado_date             = empty($this->estado_date_cfae) ? date('Y-m-d H:i:s') : $this->estado_date_cfae ;
        $eControlVenta->id_sede                 = $this->id_sede;
        $eControlVenta->id_curso_capacitacion   = $this->id_curso_capacitacion;
        $eControlVenta->promocion_curso         = $this->promocion_curso;
        $eControlVenta->id_alumno               = empty($this->id_alumno) ? 0 : $this->id_alumno ;
    
        return $eControlVenta;
    }

    public function setVentaCFAEEntity(eControlVenta $eControlVenta )
    {
        
        $this->id_venta_cfae            = empty($eControlVenta->id) ? 0 : $eControlVenta->id ;
        $this->estado                   = $eControlVenta->estado;
        $this->registration_date_cfae   = $eControlVenta->registration_date;
        $this->id_employee              = empty($eControlVenta->id_employee) ? 0 : $eControlVenta->id_employee ;
        $this->estado_date_cfae         = $eControlVenta->estado_date;
        $this->id_sede                  = empty($eControlVenta->id_sede) ? 0 : $eControlVenta->id_sede ;
        $this->id_curso_capacitacion    = empty($eControlVenta->id_curso_capacitacion) ? 0 : $eControlVenta->id_curso_capacitacion ;
        $this->promocion_curso          = $eControlVenta->promocion_curso;
    }
    
}
