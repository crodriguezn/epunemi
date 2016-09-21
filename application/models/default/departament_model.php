<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Departament_Model extends MY_Model 
{
    protected $table = 'departament';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eDepartament = new eDepartament();
        
        $eDepartament->parseRow($row);
        
        return $eDepartament;
    }
    
    function save(eDepartament &$eDepartament)
    {
        try
        {
            if (empty($eDepartament->id)) 
            {
                $eDepartament->id = $this->genId();
                 
                $this->insert($eDepartament->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eDepartament->toData(TRUE), $eDepartament->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    
    function filter(filterDepartament $filter, &$eDepartaments, &$count )
    {
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
                $eDepartament = new eDepartament();
                $eDepartament->parseRow($row, 'd_');

                $eDepartaments[] = $eDepartament;
            }
        }
        
    }

    function filterQuery( filterDepartament $filter, $useCounter=FALSE )
    {
        $select_departament = $this->buildSelectFields('d_', 'd', $this->table);
        $select = ($select_departament);
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"d\"
            WHERE 1=1
                UPPER(\"d\".\"description\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') OR 
                UPPER(\"d\".\"description_key\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%')
            " . ( $useCounter ? '' : " GROUP BY \"d\".\"id\" " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        //print_r($sql);
        return $sql;
    }
    
    
}

class eDepartament extends MY_Entity
{
    public $description;
    public $isActive;
    public $director;
    public $description_key;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->description = '';
            $this->description_key = '';
            $this->director = '';
        }
    }
}

class filterDepartament extends MY_Entity_Filter
{
    public function __construct()
    {
        parent::__construct();
        
    }
    
}