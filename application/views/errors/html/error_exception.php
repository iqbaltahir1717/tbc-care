<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Error</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="http://localhost/coreigniter/assets/core-admin/core-component/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="http://localhost/coreigniter/assets/core-admin/core-component/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://localhost/coreigniter/assets/core-admin/core-component/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="http://localhost/coreigniter/assets/core-admin/core-dist/css/AdminLTE.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" rel="stylesheet"> 
        <style type="text/css">
            .fontQuicksand{
                font-family: 'Quicksand', sans-serif;
            }

            .fontPoppins{
                font-family: 'Poppins', sans-serif;
            }
        </style>
    </head>
    <body class="hold-transition login-page fontPoppins">
		<div class="error-page">
			
			<h2 class="headline text-red"><i class="fa fa-warning text-red"></i></h2>
			<div class="error-content" style="padding-top:30px">
				<h3>An uncaught Exception was encountered</h3>
				
				<p>Type: <?php echo get_class($exception); ?></p>
				<p>Message: <?php echo $message; ?></p>
				<p>Filename: <?php echo $exception->getFile(); ?></p>
				<p>Line Number: <?php echo $exception->getLine(); ?></p>

				<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

					<p>Backtrace:</p>
					<?php foreach ($exception->getTrace() as $error): ?>

						<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

							<p style="margin-left:10px">
							File: <?php echo $error['file']; ?><br />
							Line: <?php echo $error['line']; ?><br />
							Function: <?php echo $error['function']; ?>
							</p>
						<?php endif ?>

					<?php endforeach ?>

				<?php endif ?>
			</div>
		</div>
       
        <script src="http://localhost/coreigniter/assets/core-admin/core-component/jquery/dist/jquery.min.js"></script>
        <script src="http://localhost/coreigniter/assets/core-admin/core-component/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>

