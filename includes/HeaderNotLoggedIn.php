<?php
    if (isset($_SESSION["SESS_MEMBER_ID"])){
        $msg = "You are already logged in";
        header("location:index.php?message=$msg");
    }

?>

<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<a class="navbar-brand" href="index.html"><img src="images/logo.jpg" class="logo"></a>
		
        
      </div>
    </nav>