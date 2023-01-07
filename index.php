<?php

  $path = $_SERVER["REQUEST_URI"];

  //  Trim / at the back of the url to avoid switching back to homepage
  $path = trim( $path , "/" );

  // Removes all URL parameters that starts from '?'
  $path = parse_url( $path, PHP_URL_PATH );

  switch( $path ) {
    case 'login';
      require 'pages/login.php';
      break;
    case 'signup';
      require 'pages/signup.php';
      break;
    case 'dashboard';
      require 'pages/dashboard.php';
      break;
    case 'post';
      require 'pages/post.php';
      break;
    case 'manage-posts';
      require 'pages/manage-posts.php';
      break;
    case 'manage-posts-add';
      require 'pages/manage-posts-add.php';
      break;
    case 'manage-posts-edit';
      require 'pages/manage-posts-edit.php';
      break;
    case 'manage-users';
      require 'pages/manage-users.php';
      break;
    case 'manage-users-add';
      require 'pages/manage-users-add.php';
      break;
    case 'manage-users-edit';
      require 'pages/manage-users-edit.php';
      break;
      case 'signup';
      require 'pages/signup.php';
      break;
    case 'logout';
      require 'pages/logout.php';
      break;
    default:
      require 'pages/home.php';
      break;
  }