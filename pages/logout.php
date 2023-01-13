<?php

// make sure user is logged in 
if ( Authentication::isLoggedIn() ) {
    // only if the user is logged in should it trigger logout
    Authentication::logout();    
}

header('Location: /login');
exit;