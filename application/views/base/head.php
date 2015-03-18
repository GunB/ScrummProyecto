<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>SCRUM</title>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>img-static/favicon.ico">
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
        <link href="<?php echo base_url(); ?>plugin/stylesheets/bootstrap.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>plugin/stylesheets/bootstrap-responsive.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>plugin/stylesheets/common.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>plugin/stylesheets/fontawesome.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>plugin/stylesheets/project.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>plugin/stylesheets/index.css" media="screen" rel="stylesheet" type="text/css" />
        <!-- Typekit fonts require an account and a kit containing the fonts used. see https://typekit.com/plans for details. <script type="text/javascript" src="//use.typekit.net/YOUR_KIT_ID.js"></script>
      <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
        -->
        <script src="<?php echo base_url(); ?>plugin/js/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>plugin/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>plugin/js/jquery.validate.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>plugin/js/jquery.validate.min.js" type="text/javascript"></script>

        
        

        <script>
            function blink(selector) {
                $(selector).fadeOut('slow', function() {
                    $(this).fadeIn('slow', function() {
                        blink(this);
                    });
                });
            }

            $(document).on("ready", function() {
                blink('.blink');
            });
        </script>
    </script>
</head>