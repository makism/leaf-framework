<html>
 <head>
  <title><?php echo $title; ?></title>
   <link rel="shortcut icon" href="<?php echo baseDir(); ?>favicon.ico" type="image/x-icon" />
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-7" /> 
  <style type="text/css">
	* {
		font-family: Tahoma, sans-serif;
	}
    
    body {
        background-color: #ffffff;
        padding: 0px 0px;
        margin: 0px 0px;
        color: #909090;
    }
    
    a:link, a:visited, a:active, a:hover {
        color: inherit;
    }
    
    cite {
        border-bottom: 1px dashed #e0e0e0;
    }
    
    #LeafVersion {
        padding: 3px;
        margin: 0px 0px;
        text-align: right;
        font-size: 10px;
        background-color: #f7f7f7;
    }

	#Container {
	   padding: 10px;
	}
	
	#Container #Title {
	   font-size: 16px;
	}
	
	#Container #Title img {
        vertical-align: middle;
	}
	
	#Container #Intro {
	   font-size: 12px;
	   width: 400px;
	   color: #666666;
	   text-indent: 35px;
	   text-align: justify;
	}
	
	#thankyou {
		text-align: right;
	}
	
  </style>
 </head>
 <body>
  <div id="LeafVersion">
    <?php echo LEAF_REL_VERSION; ?> (<?php echo LEAF_REL_STATUS; ?>)
  </div>
 
  <div id="Container">
    <div id="Title">
        <img src="<?php echo baseDir(); ?>content/leaf/leaf-logo_resized.jpg" alt="leaf logo"/>
        Καλώς ήρθατε στο leaf framework!
    </div>
    <br />
    <div id="Intro">
		<p>Συγχαρητήρια.</p>

		<p>Για να βλέπεται αυτή τη σελίδα, σημαίνει πώς η εγκατάσταση του leaf
		είναι σωστά ρυθμισμένη και το σύστημα σας συναντά όλες τις απαιτήσεις.</p>

		<p>Για αρχή, σας συμβουλεύουμε να ρίξετε μια γρήγορη ματιά στις δοκιμαστικές
		εφαρμογές που υπάρχουν στον υποκατάλογο <cite>applications</cite> και επιπλέον,
		συμβουλευτείτε το <cite>εχγειρίδιο χρήσης</cite> ή και το <cite>api doc</cite>.</p>

		<p>Μην ξεχνάτε να επισκέπτεστε συχνά το
		<a href="http://sourceforge.net/projects/leaf-framework">sourceforge.net/projects/leaf-framework</a>
		για νέα και ενημερώσεις.</p>
        
        <br />
        <p id="thankyou">
            Σας ευχαριστούμε για το ενδιαφέρον σας :-)
        </p>
    </div>
  </div>

 </body>
</html>
