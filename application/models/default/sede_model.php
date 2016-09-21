<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sede_Model extends MY_Model 
{
    protected $table = 'sede';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eSede = new eSede();
        
        $eSede->parseRow($row);
        
        return $eSede;
    }
    
    function save(eSede &$eSede)
    {
        try
        {
            if (empty($eSede->id)) 
            {
                $eSede->id = $this->genId();
                 
                $this->insert($eSede->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eSede->toData(TRUE), $eSede->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    
    function filter(filterSede $filter, &$eSedes, &$count )
    {
        $eSedes = array();
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
                $eSede = new eSede();
                $eSede->parseRow($row, 's_');

                $eSedes[] = $eSede;
                
            }
        }
        
    }

    function filterQuery(filterSede $filter, $useCounter=FALSE )
    {
        $select_sede = $this->buildSelectFields('s_', 's', $this->table);
        
        $select = ($select_sede);
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"s\"
            WHERE 1=1
                AND (
                    UPPER(\"s\".\"name\") LIKE UPPER('%" . ( $this->db->escape_like_str($filter->text) ) . "%') 
                )
            " . ( !$filter->isActive ? '' : " AND \"s\".\"isActive\"=" . ( $this->db->escape(1) ) . " " ) . "
            " . ( $useCounter ? '' : " GROUP BY \"s\".\"id\" " ) . "
            " . ( $useCounter ? '' : " ORDER BY \"s\".\"name\" ASC " ) . "
            " . ( $useCounter || is_null($filter->limit) || is_null($filter->offset) ? '' : " LIMIT ".( $filter->limit )." OFFSET ".( $filter->offset )." " ) . "
        ";
        //Helper_Log::write($sql);
        return $sql;
    }
    
}

class eSede extends MY_Entity
{
    public $name;
    public $direccion;
    public $isActive;
    public $id_departament;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->name             = '';
            $this->direccion        = '';
            $this->id_departament   = 0;
            $this->isActive         = 0;
        }
    }
}

class filterSede extends MY_Entity_Filter
{
    public $id_departament;
    public $isActive;
    public function __construct()
    {
        parent::__construct();
        $this->id_departament   = NULL;
        $this->isActive         = FALSE;
    }
    
}