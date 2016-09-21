<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Alumno_Model extends MY_Model
{
    protected $table = 'alumno';

    function __construct()
    {
        parent::__construct();
    }

  
    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);

        $eAlumno = new eAlumno();
        
        $eAlumno->parseRow($row);

        return $eAlumno;
    }
    
    function save(eAlumno &$eAlumno)
    {
        try
        {
            if( empty($eAlumno->id) )
            {
                $eAlumno->id = $this->genId();
                $this->insert($eAlumno->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eAlumno->toData(FALSE), $eAlumno->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
}

class eAlumno extends MY_Entity
{
    public $id_person;
    public $registration_date;
    public $estado;
    public $estado_date;
    
    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_person            = '';
            $this->registration_date    = '';
            $this->estado               = '';
            $this->estado_date          = '';
        }
    }
}