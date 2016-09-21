<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sale_Control_Model extends MY_Model 
{
    protected $table = 'sale_copntrol';
    
    function __construct() 
    {
        parent::__construct();
    }

    function load($value, $by = 'id', $except_value = '', $except_by = 'id')
    {
        $row = parent::load($value, $by, $except_value, $except_by);
        
        $eSaleControl = new eSaleControl();
        
        $eSaleControl->parseRow($row);
        
        return $eSaleControl;
    }
    
    function save(eSaleControl &$eSaleControl)
    {
        try
        {
            if (empty($eSaleControl->id)) 
            {
                $eSaleControl->id = $this->genId();
                 
                $this->insert($eSaleControl->toData());
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_INSERT );
            }
            else
            {
                $this->update($eSaleControl->toData(TRUE), $eSaleControl->id);
                Helper_App_Log::write( $this->lastQuery(), FALSE, Helper_App_Log::LOG_UPDATE );
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    
    
    function filter(filterSaleControl $filter, &$ePersons, &$SaleControls, &$count )
    {
        $SaleControls = array();
        $ePersons = array();
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
                $eSaleControl = new eSaleControl();
                $eSaleControl->parseRow($row, 'sc_');

                $SaleControls[] = $eSaleControl;
                
                $ePerson = new ePerson();
                $ePerson->parseRow($row, 'p_');

                $ePersons[] = $ePerson;
                
            }
        }
        
    }

    function filterQuery(filterSaleControl $filter, $useCounter=FALSE )
    {
        $select_employee = $this->buildSelectFields('e_', 'e', 'employee');
        $select_person = $this->buildSelectFields('p_', 'p', 'person');
        $select_salecontrol = $this->buildSelectFields('sc_', 'sc', $this->table);
        $select = ($select_employee.','.$select_person.','.$select_salecontrol);
        $sql = "
            SELECT 
                ".( $useCounter ? 'COUNT(*) AS "count"' : $select )."
            FROM \"".( $this->table )."\" AS \"sc\"
                INNER JOIN \"person\" AS \"p\" ON \"p\".\"id\" = \"sc\".\"id_person\" 
                INNER JOIN \"employee\" AS \"e\" ON \"e\".\"id\" = \"sc\".\"id_employee\" 
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
    
    
}

class eSaleControl extends MY_Entity
{
    public $id_person;
    public $id_employee;
    public $estado;
    public $registration_date;
    public $update_date;

    public function __construct($useDefault = TRUE)
    {
        parent::__construct($useDefault);
        
        if( $useDefault )
        {
            $this->id_person            = 0;
            $this->id_employee          = 0;
            $this->estado               = '';
            $this->registration_date    = '';
            $this->update_date          = '';
        }
    }
}

class filterSaleControl extends MY_Entity_Filter
{
    public $id_employee;
    public function __construct()
    {
        parent::__construct();
        $this->id_employee   = NULL;
    }
    
}