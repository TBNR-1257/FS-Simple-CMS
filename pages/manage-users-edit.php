<?php 

  // only admin can access
  if( !Authentication::whoCanAccess('admin') ) {
    header('Location: /dashboard');
    exit;
  }


  // load user data
  $user = User::getUserById( $_GET['id'] );


  //set csrf token
  CSRF::generateToken( 'edit_user_form' );

  //make sure post request
  if( $_SERVER["REQUEST_METHOD"] === 'POST' ) {
    
    // do error check

    // do a check to find out should we do password update or not
    $is_password_changed = (
      ( isset( $_POST['password'] ) && !empty( $_POST['password'] ) ) ||
      ( isset( $_POST['confirm_password'] ) && !empty( $_POST['confirm_password'] ) ) 
      ? true : false
    );


    
      // if both password field is empty skip error checking for both fields
      $rules = [
        'name' => 'required',
        'email' => 'email_check',
        'role' => 'required',
        'csrf_token' => 'edit_user_form_csrf_token'
      ];

      // f password is updated
      if ( $is_password_changed ) {
        $rules['password'] = 'password_check';  // make sure the length >= 8
        $rules['confirm_password'] = 'is_password_match';  // make sure both passwords are identical
      }

      $error = FormValidation::validate( $_POST, $rules );


      // if email has changed m,ake sure it cannot belong to aother user 
      // we check for eamil changes 
      if( $user->email !== $_POST['email'] ) {

        // do database check t make sure new email wasn't already in use
        $error .= FormValidation::checkEmailUniqueness( $_POST['email'] );
      }


      // make sure no error
      if( !$error ) {

        // update user
        User::update(
          $user->id,
          $_POST['name'],
          $_POST['email'],
          $_POST['role'],
          ( $is_password_changed ? $_POST['password'] : null ) 
        );


        // remove the csrf token
        CSRF::removeToken( 'edit_user_form' );

        //redirect
        header('Location: /manage-users');
        exit;

      }

  }
 

  require dirname(__DIR__) . "/parts/header.php";

?>


  <body>
    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Edit User</h1>
      </div>
      <div class="card mb-2 p-4">
      <?php require dirname( __DIR__ ) . '/parts/error_box.php'; ?>
        <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
          <div class="mb-3">
            <div class="row">
              <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user->name ?>" />
              </div>
              <div class="col">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->email ?>" />
              </div>
            </div>
          </div>
          <div class="mb-3">
            <div class="row">
              <div class="col">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" />
              </div>
              <div class="col">
                <label for="confirm-password" class="form-label"
                  >Confirm Password</label
                >
                <input
                  type="password"
                  class="form-control"
                  id="confirm-password"
                  name="confirm_password"
                />
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" >
              <option value="">Select an option</option>
              <option value="user" <?php echo ( $user->role == 'user' ? 'selected' : '' ); ?>>User</option>
              <option value="editor" <?php echo ( $user->role == 'editor' ? 'selected' : '' ); ?>>Editor</option>
              <option value="admin" <?php echo ( $user->role == 'admin' ? 'selected' : '' ); ?>>Admin</option>
            </select>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
          <input 
          type="hidden" 
          name="csrf_token" 
          value="<?php echo CSRF::getToken( 'edit_user_form' ); ?>" 
          >
        </form>
      </div>
      <div class="text-center">
        <a href="/manage-users" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Users</a
        >
      </div>
    </div>


<?php

  require dirname(__DIR__) . "/parts/footer.php";
