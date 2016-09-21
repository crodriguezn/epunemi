<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Curso_Capacitacion_Sede
{
    
    static public function listSede($txt_filter, $limit, $offset)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mSede Sede_Model */
        $mSede =& $MY->mSede;
        
        $eSedes = array();
        $count = 0;
        try
        {
            $filter = new filterSede();
            
            $filter->limit = $limit;
            $filter->offset = $offset;
            $filter->text = $txt_filter;
            $filter->isActive = TRUE;
            $filter->id_departament = NULL;
        
            $mSede->filter($filter, $eSedes/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eSedes' => $eSedes,
            'count' => $count
        ));
        
        return $oBus;
    }
    
    
    static public function saveProfile( eProfile $eProfile )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mProfile Profile_Model */
        $mProfile =& $MY->mProfile;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {

            $isEditable = TRUE;
            if( !$eProfile->isEmpty() )
            {
                $eProfileT = $mProfile->load( $eProfile->id );
                
                if( !Helper_App_Session::isSuperAdminProfile())
                {
                    if( $eProfileT->isSuperAdmin == 1 || $eProfileT->isAdmin == 1 )
                    {
                        throw new Exception("Prohibido editar éste perfil");
                    }
                    $isEditable = $eProfileT->isEditable == 1;
                }
                
                $eProfile->isSuperAdmin = $eProfileT->isSuperAdmin;
                $eProfile->isAdmin      = $eProfileT->isAdmin;
                $eProfile->isEditable      = $eProfileT->isEditable;
                
            }
            
            if( $isEditable )
            {
                $mProfile->save($eProfile);
            }
            
            $oTransaction->commit();
            
            $oBus->isSuccess(TRUE);
            $oBus->message("Guardado exitosamente");
        }
        catch( Exception $e )
        {
            $oTransaction->rollback();
            
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        return $oBus;
    } 
    
    static public function saveProfilePermission( $id_profile, $arr_eProfilePermissions )
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mProfilePermission Profile_Permission_Model */
        $mProfilePermission =& $MY->mProfilePermission;
        
        $oTransaction = new MY_Business();
        
        $oTransaction->begin();
        
        try
        {
            
            $mProfilePermission->deleteByProfile($id_profile);
            
            /* @var $eProfilePermission eProfilePermission*/
            foreach( $arr_eProfilePermissions as $eProfilePermission )
            {
                if( !empty($eProfilePermission->id_permission) ) 
                {
                    $mProfilePermission->save($eProfilePermission);
                }
            }
            
            $oTransaction->commit();
            
            $oBus->isSuccess(TRUE);
            $oBus->message("Guardado exitosamente");
        }
        catch( Exception $e )
        {
            $oTransaction->rollback();
            
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        return $oBus;
    } 
    
}