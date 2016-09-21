<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Person_Model extends MY_Model
{
    protected $table = 'person';

    function __construct()
    {
        parent::__construct();
    }

  
    function loadByDocument( $document, $except_value='' )
    {
        $ePerson = $this->load($document, 'document', $except_value);

        return $ePerson;
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);

        $ePerson = new ePerson();
        
        $ePerson->parseRow($row);

        return $ePerson;
    }
    
    function save(ePerson &$ePerson)
    {
        try
        {
            if( empty($ePerson->id) )
            {
                $ePerson->id = $this->genId();
                $this->insert($ePerson->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($ePerson->toData(FALSE), $ePerson->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    
    function existDocument($document)
    {
        $sql = "select count(DOCUMENT) from person where DOCUMENT='$document'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($result[0]->count == 0) 
        {
            return 'success';
        } 
        else 
        {
            return 'error';
        }
    }

}

class ePerson extends MY_Entity
{
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
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name                     = '';
            $this->surname                  = '';
            $this->tipo_documento           = '';
            $this->document                 = '';
            $this->birthday                 = '';
            $this->gender                   = '';
            $this->estado_civil             = '';
            $this->email                    = '';
            $this->nivel_academico          = NULL;
            $this->discapacidad             = NULL;
            $this->id_ciudad                = NULL;
            $this->calle_principal          = NULL;
            $this->calle_secundaria         = NULL;
            $this->referencia_domicilio     = NULL;
            $this->num_casa                 = NULL;
            $this->telefono_casa            = NULL;
            $this->telefono_trabajo         = NULL;
            $this->telefono_cell_1          = NULL;
            $this->telefono_cell_2          = NULL;
            $this->email_trabajo            = NULL;
            $this->email_alterno            = NULL;
            $this->ref_1_surname_name       = NULL;
            $this->ref_1_direccion          = NULL;
            $this->ref_1_tlfo_fijo_cell     = NULL;
            $this->ref_1_parentesco         = NULL;
            $this->ref_2_surname_name       = NULL;
            $this->ref_2_direccion          = NULL;
            $this->ref_2_tlfo_fijo_cell     = NULL;
            $this->ref_2_parentesco         = NULL;
            $this->tipo_sangre              = NULL;
        }
    }
}