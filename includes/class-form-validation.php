<?php

// static class
class FormValidation
{
    public static function checkEmailUniqueness( $email)
    {

        // check if email already used by another user
        $user = DB::connect()->select(
            'SELECT * FROM users WHERE email = :email',
            [
                'email' => $email
            ]
        );

        // if user with same email already exists 
        if ( $user ) {
            return 'Email is already in use';
        }

        return false;
    }



    public static function validate( $data, $rules = [] )
    {
        $error = false;

        // do all the form validation 
        foreach( $rules as $key => $condition )
        {
            switch( $condition )
            {
                // ensure value is not empty
                case 'required':
                    if ( empty( $data[$key] ) )
                    {
                        $error .= 'This field (' . $key . ') is empty<br />'; 
                    }
                    break;

                // make sure password field is not empty & at least 8 char
                case 'password_check':
                    if ( empty( $data[$key] ) )
                    {
                        $error .= 'This field (' . $key . ') is empty<br />'; 
                    }
                    else if ( strlen( $data[$key] ) < 8 ) {
                        $error .= 'Password should be atleast 8 characters<br />';
                    }
                    break;


                // ensure passwords match
                case 'is_password_match':
                    if ( $data['password'] !== $data['confirm_password'] ) {
                        $error .= "Passwords does not match<br />";
                    }
                    break;

                // ensure email is valid
                case 'email_check':
                    if ( !filter_var( $data[$key], FILTER_VALIDATE_EMAIL ) )
                    {
                        $error .= "The Email provided is invalid<br />";
                    }
                    break;

                // make sure login form csrf token is match
                case 'login_form_csrf_token':
                    // $data[$key] is $_POST['csrf_token'];
                    if ( !CSRF::verifyToken( $data[$key], 'login_form' ) ) {
                        $error .= "Invalid CSRF Token<br />";
                    }
                    break;

                // make sure signup form csrf token is match
                case 'signup_form_csrf_token':
                    // $data[$key] is $_POST['csrf_token'];
                    if ( !CSRF::verifyToken( $data[$key], 'signup_form' ) ) {
                        $error .= "Invalid CSRF Token<br />";
                    }
                    break;

                // make sure edit user form csrf token is match
                case 'edit_user_form_csrf_token':
                    // $data[$key] is $_POST['csrf_token'];
                    if ( !CSRF::verifyToken( $data[$key], 'edit_user_form' ) ) {
                        $error .= "Invalid CSRF Token<br />";
                    }
                    break;

                // make sure add user form csrf token is match
                case 'add_user_form_csrf_token':
                    // $data[$key] is $_POST['csrf_token'];
                    if ( !CSRF::verifyToken( $data[$key], 'add_user_form' ) ) {
                        $error .= "Invalid CSRF Token<br />";
                    }
                    break;

                // make sure delete user form csrf token is match
                case 'delete_user_form_csrf_token':
                    // $data[$key] is $_POST['csrf_token'];
                    if ( !CSRF::verifyToken( $data[$key], 'delete_user_form' ) ) {
                        $error .= "Invalid CSRF Token<br />";
                    }
                    break;
                    
                // make sure edit post form csrf token is match
                case 'edit_post_form_csrf_token':
                    // $data[$key] is $_POST['csrf_token'];
                    if ( !CSRF::verifyToken( $data[$key], 'edit_post_form' ) ) {
                        $error .= "Invalid CSRF Token<br />";
                    }
                    break;

                // make sure add post form csrf token is match
                case 'add_post_form_csrf_token':
                    // $data[$key] is $_POST['csrf_token'];
                    if ( !CSRF::verifyToken( $data[$key], 'add_post_form' ) ) {
                        $error .= "Invalid CSRF Token<br />";
                    }
                    break;

                // make sure delete post form csrf token is match
                case 'delete_post_form_csrf_token':
                    // $data[$key] is $_POST['csrf_token'];
                    if ( !CSRF::verifyToken( $data[$key], 'delete_post_form' ) ) {
                        $error .= "Invalid CSRF Token<br />";
                    }
                    break;
        
            }
        }


        return $error;

    }


}