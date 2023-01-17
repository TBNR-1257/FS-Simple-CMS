<?php 

  $post = Post::getPostByID( $_GET['id'] );


  require dirname(__DIR__) . "/parts/header.php";

?>


  <body>
    <div class="container mx-auto my-5" style="max-width: 500px;">
      <h1 class="h1 mb-4 text-center"><?php echo $post->title ?></h1>
      <?php 
      
        echo nl2br( $post->content );

        // // split the content by paragraph using breakline <br> 
        // $paragraphs = preg_split( '/\n\s*\n/', $post->content );

        // // echo out each paragraph using <p>
        // foreach( $paragraphs as $string )
        // {
        //   echo '<p>';
          
        //   // break it up by single breakline
        //   $lines = preg_split( '/\n/', $string );
        //   foreach( $lines as $line )
        //   {
        //     echo $line . '<br />';
        //   }
          
        //   echo '</p>';
        // }
      
      ?>
      <div class="text-center mt-3">
        <a href="/home" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back</a
        >
      </div>
    </div>

  
<?php

  require dirname(__DIR__) . "/parts/footer.php";