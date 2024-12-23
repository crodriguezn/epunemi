<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Curso_Capacitacion__Sede_model extends MY_Model 
{
    protected $table = 'curso_capacitacion__sede';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eCursoCapacitacionSede = new eCursoCapacitacionSede();
        
        $eCursoCapacitacionSede->parseRow($row);
        
        return $eCursoCapacitacionSede;
    }
    
    function save(eCursoCapacitacionSede &$eCursoCapacitacionSede)
    {
        try
        {
            if (empty($eCursoCapacitacionSede->id)) 
            {
                $eCursoCapacitacionSede->id = $this->genId();
                 
                $this->insert($eCursoCapacitacionSede->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eCursoCapacitacionSede->toData(TRUE), $eCursoCapacitacionSede->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    function listAllCursoCapacitacion($id_sede=NULL)
    {
        $query = $this->db->query( $this->queryAll($id_sede) );

        $rows = $query->result_array();
        
        $ePaises = array();
        if( !empty($rows) )
        {
            foreach( $rows as $row )
            {
                $ePais = new ePais();
                $ePais->parseRow($row);
                
                $ePaises[] = $ePais;
            }
        }
            
        return $ePaises;
    }
    
    function queryAllCursoCapacitacion( )
    {
        $sql = "
            SELECT *
            FROM ".( $this->table )."
            WHERE 1=1
                AND (
                    nombre LIKE '%".( $this->db->escape_like_str($txt_filter) )."%'
                )
            ".( is_null($limit) || is_null($offset) ? '' : " LIMIT $limit OFFSET $offset " )."
        ";

        return $sql;
    }
    
    /*function filter(filterEmployee $filter, &$eEmployees, &$ePersons, &$eDepartaments, &$count )
    {
        $eEmployees = array();
        $ePersons = array();
        $eDepartaments = array();
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
                $eEmployee = new eEmployee();
                $eEmployee->parseRow($row, 'e_');

                $eEmployees[] = $eEmployee;
                
                $ePerson = new ePerson();
                $ePerson->parseRow($row, 'p_');

                $ePersons[] = $ePerson;
                
                $eDepartament = new eDepartament();
                $eDepartament->parseRow($row, 'd_');

                $eDepartaments[] = $eDepartament;
            }
        }
        
    }

    function filterQuery(filterEmployee $filter, $useCounter=FALSE )
    {
        $select_employee = $this->buildSelectFields('e_', 'e', $this->table);
        $select_person = $this->buildSelectFields('p_', 'p', 'person');
        $select_departament = $this->buildSelectFields('d_', 'd', 'departament');
        $select = ($select_employee.','.$select_person.','.$select_departament);
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"u\"
                INNER JOIN \"person\" AS \"p\" ON \"p\".\"id\" = \"e\".\"id_person\" 
                INNER JOIN \"departament\" AS \"d\" ON \"d\".\"id\" = \"e\".\"id_departament\" 
            WHERE 1=1
                AND (
                    UPPER(\"p\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"document\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"p\".\"surname\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                    UPPER(\"d\".\"description\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR
                    UPPER(\"d\".\"description_key\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
                )
            " . ( $useCounter ? '' : " GROUP BY \"e\".\"id\", \"p\".\"id\", \"d\".\"id\" " ) . "
            " . ( $useCounter ? '' : " ORDER BY \"surname\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        return $sql;
    }
    */
    
}

class eCursoCapacitacionSede extends MY_Entity
{
    public $id_curso_capacitacion;
    public $id_sede;
    public $id_profile;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_curso_capacitacion    = 0;
            $this->id_sede                  = 0;
            $this->id_profile               = 0;
        }
    }
}

class filterCursoCapacitacionSede extends MY_Entity_Filter
{
    public $id_profile;
    
    public function __construct()
    {
        parent::__construct();
        $this->id_profile   = NULL;
    }
    
}