<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Control_Venta_Model extends MY_Model 
{
    protected $table = 'control_venta';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eControlVenta = new eControlVenta();
        
        $eControlVenta->parseRow($row);
        
        return $eControlVenta;
    }
    
    function save(eControlVenta &$eControlVenta)
    {
        try
        {
            if (empty($eControlVenta->id)) 
            {
                $eControlVenta->id = $this->genId();
                 
                $this->insert($eControlVenta->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eControlVenta->toData(TRUE), $eControlVenta->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    
    function filter(filterControlVenta $filter, &$eControlVentas, &$ePersonas, &$eSedes, &$eCursoCapacitaciones, &$count )
    {
        $eControlVentas         = array();
        $ePersonas              = array();
        $eSedes                  = array();
        $eCursoCapacitaciones   = array();
        $count = 0;
        
        $queryR = $this->db->query($this->filterQuery($filter));
        if( $queryR === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
        
        $queryC = $this->db->query($this->filterQuery($filter,TRUE));
        if( $queryC === FALSE )
        {
            Helper_Log::write( $this->messageError(__FUNCTION__,FALSE), Helper_Log::LOG_DB);
            throw new Exception("Problema ejecución en Base de Datos, ver log de errores. Consulte con Sistemas");
        }
 
        $row = $queryC->row_array();
        //$count = isset($row['count'])? $row['count']: NULL;
        $count = $row['count'];
        
        $rows = $queryR->result_array();
        
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $eControlVenta = new eControlVenta();
                $eControlVenta->parseRow($row, 'cv_');
                $eControlVentas[] = $eControlVenta;
                
                $ePerson = new ePerson();
                $ePerson->parseRow($row, 'p_');
                $ePersonas[] = $ePerson;
                
                $eSede = new eSede();
                $eSede->parseRow($row, 's_');
                $eSedes[] = $eSede;
                
                $eCursoCapacitacion = new eCursoCapacitacion();
                $eCursoCapacitacion->parseRow($row, 'cc_');
                $eCursoCapacitaciones[] = $eCursoCapacitacion;

            }
        }
        
    }

    function filterQuery(filterControlVenta $filter, $useCounter=FALSE )
    {
        $select_sede = $this->buildSelectFields('s_', 's', 'sede');
        $select_person = $this->buildSelectFields('p_', 'p', 'person');
        $select_cursocapacitacion = $this->buildSelectFields('cc_', 'cc', 'curso_capacitacion');
        $select_controlventa = $this->buildSelectFields('cv_', 'cv', $this->table);
        $select = ($select_sede.','.$select_person.','.$select_controlventa.','.$select_cursocapacitacion);
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"cv\"
                INNER JOIN \"alumno\" AS \"a\" ON \"a\".\"id\" = \"cv\".\"id_alumno\" 
                INNER JOIN \"person\" AS \"p\" ON \"p\".\"id\" = \"a\".\"id_person\" 
                INNER JOIN \"curso_capacitacion\" AS \"cc\" ON \"cc\".\"id\" = \"cv\".\"id_curso_capacitacion\" 
                INNER JOIN \"sede\" AS \"s\" ON \"s\".\"id\" = \"cv\".\"id_sede\" 
            WHERE 1=1
                AND (
                    UPPER(\"p\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"document\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"surname\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"s\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR
                    UPPER(\"cc\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR
                    UPPER(\"cc\".\"name_key\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
                ".( !is_null($filter->id_employee) ? ' AND "cv"."id_employee"='.$filter->id_employee:"")."
            " . ( $useCounter ? '' : " ORDER BY \"p\".\"surname\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        return $sql;
    }
    
    
}

class eControlVenta extends MY_Entity
{
    public $id_alumno;
    public $registration_date;
    public $estado;
    public $id_employee;
    public $estado_date;
    public $id_sede;
    public $id_curso_capacitacion;
    public $promocion_curso;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_alumno                = 0;
            $this->id_employee              = 0;
            $this->id_sede                  = 0;
            $this->id_curso_capacitacion    = 0;
            $this->registration_date        = '';
            $this->estado                   = '';
            $this->estado_date              = NULL;
            $this->promocion_curso          = NULL;
        }
    }
}

class filterControlVenta extends MY_Entity_Filter
{
    public $id_employee;
    public function __construct()
    {
        parent::__construct();
        $this->id_employee   = NULL;
    }
    
}