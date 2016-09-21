<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Venta_Cfae
{
//    static public function loadProfile( $id_profile )
//    {
//        $oBus = new Response_Business();
//        
//        $MY =& MY_Controller::get_instance();
//
//        /* @var $mProfile Profile_Model */
//        $mProfile =& $MY->mProfile;
//        
//        /* @var $eProfile eProfile  */
//        $eProfile = $mProfile->load( $id_profile );
//        
//        $oBus->isSuccess( !$eProfile->isEmpty() );
//        $oBus->data(array(
//            'eProfile' => $eProfile
//        ));
//        
//        return $oBus;
//    }
//    
    static public function listVentaCFAE($txt_filter, $limit, $offset)
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mControlVenta Control_Venta_Model */
        $mControlVenta =& $MY->mControlVenta;
        
        /* @var $mEmployee Employee_Model */
        $mEmployee =& $MY->mEmployee;
        $eControlVentas = array();
        $ePersonas  = array();
        $eSedes     = array();
        $eCursoCapacitaciones    = array();
        $count      = 0;
        
        $id_employee = NULL;
        
        if(!Helper_App_Session::isSuperAdminProfile())
        {
            /* @var $eEmployee eEmployee */
            $eEmployee = $mEmployee->load(Helper_App_Session::getPersonId(), 'id_person');
            $id_employee = $eEmployee->id;
        }
        
        try
        {
            $filter = new filterControlVenta();
            
            $filter->limit = $limit;
            $filter->offset = $offset;
            $filter->text = $txt_filter;
            $filter->id_employee = $id_employee;
        
            $mControlVenta->filter($filter, $eControlVentas/*REF*/, $ePersonas/*REF*/, $eSedes/*REF*/, $eCursoCapacitaciones/*REF*/, $count/*REF*/ );
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $ex )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $ex->getMessage() );
        }
        
        $oBus->data(array(
            'eControlVentas'        => $eControlVentas,
            'ePersonas'             => $ePersonas,
            'eSedes'                => $eSedes,
            'eCursoCapacitaciones'  => $eCursoCapacitaciones,
            'count'                 => $count
        ));
        
        return $oBus;
    }
    
//    
//    static public function saveProfile( eProfile $eProfile )
//    {
//        $oBus = new Response_Business();
//        
//        $MY =& MY_Controller::get_instance();
//        
//        /* @var $mProfile Profile_Model */
//        $mProfile =& $MY->mProfile;
//        
//        $oTransaction = new MY_Business();
//        
//        $oTransaction->begin();
//        
//        try
//        {
//
//            $isEditable = TRUE;
//            if( !$eProfile->isEmpty() )
//            {
//                $eProfileT = $mProfile->load( $eProfile->id );
//                
//                if( !Helper_App_Session::isSuperAdminProfile())
//                {
//                    if( $eProfileT->isSuperAdmin == 1 || $eProfileT->isAdmin == 1 )
//                    {
//                        throw new Exception("Prohibido editar éste perfil");
//                    }
//                    $isEditable = $eProfileT->isEditable == 1;
//                }
//                
//                $eProfile->isSuperAdmin = $eProfileT->isSuperAdmin;
//                $eProfile->isAdmin      = $eProfileT->isAdmin;
//                $eProfile->isEditable      = $eProfileT->isEditable;
//                
//            }
//            
//            if( $isEditable )
//            {
//                $mProfile->save($eProfile);
//            }
//            
//            $oTransaction->commit();
//            
//            $oBus->isSuccess(TRUE);
//            $oBus->message("Guardado exitosamente");
//        }
//        catch( Exception $e )
//        {
//            $oTransaction->rollback();
//            
//            $oBus->isSuccess(FALSE);
//            $oBus->message( $e->getMessage() );
//        }
//        
//        return $oBus;
//    } 
//    
//    static public function saveProfilePermission( $id_profile, $arr_eProfilePermissions )
//    {
//        $oBus = new Response_Business();
//        
//        $MY =& MY_Controller::get_instance();
//        
//        /* @var $mProfilePermission Profile_Permission_Model */
//        $mProfilePermission =& $MY->mProfilePermission;
//        
//        $oTransaction = new MY_Business();
//        
//        $oTransaction->begin();
//        
//        try
//        {
//            
//            $mProfilePermission->deleteByProfile($id_profile);
//            
//            /* @var $eProfilePermission eProfilePermission*/
//            foreach( $arr_eProfilePermissions as $eProfilePermission )
//            {
//                if( !empty($eProfilePermission->id_permission) ) 
//                {
//                    $mProfilePermission->save($eProfilePermission);
//                }
//            }
//            
//            $oTransaction->commit();
//            
//            $oBus->isSuccess(TRUE);
//            $oBus->message("Guardado exitosamente");
//        }
//        catch( Exception $e )
//        {
//            $oTransaction->rollback();
//            
//            $oBus->isSuccess(FALSE);
//            $oBus->message( $e->getMessage() );
//        }
//        
//        return $oBus;
//    } 
//    
}