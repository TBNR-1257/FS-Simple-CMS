<?php

class CSRF
{

    // generate csrf token
    public static function generateToken( $prefix = '' )
    {

        // lets say the prefix = login_form 
        //then the $_SESSION['login_form_csrf_token]
        if ( !isset( $_SESSION[ $prefix . '_csrf_token' ] ) ) {
            $_SESSION[$prefix . '_csrf_token'] = bin2hex( random_bytes(32) );  
        }

    }


    // verify csrf token ( make sure it matches with the one provided in form data )
    public static function verifyToken( $formToken, $prefix = '' )
    {
        if( isset( $_SESSION[ $prefix . '_csrf_token' ] ) && $formToken === $_SESSION[ $prefix . '_csrf_token' ] ) {
            return true;
        }
        return false;
    } 


    // retrieve existing csrf token ( if available )
    public static function getToken( $prefix = '' ) 
    {

        if( isset( $_SESSION[ $prefix . '_csrf_token' ] ) ) {
            return $_SESSION[ $prefix . '_csrf_token' ];
        }
        return false;
    }



    public static function removeToken( $prefix = '' )
    {
        if( isset( $_SESSION[ $prefix . '_csrf_token' ] ) ) {
            unset ( $_SESSION[ $prefix . '_csrf_token' ] );
        }
    }


}