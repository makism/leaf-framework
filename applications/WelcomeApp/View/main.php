<html>
 <head>
  <title><?php echo $title; ?></title>
   <link rel="shortcut icon" href="/leaf/favicon.ico" type="image/x-icon" />
  <style type="text/css">
	* {
		font-family: Arial, serif;
	}
    
    body {
        background-color: 382514;
        padding: 0px 0px;
        margin: 0px 0px;
    }
	
	a:link, a:visited, a:active {
		text-decoration: none;
		color: #000000;
	}
	
	a:hover {
		font-style: italic;
	}
    
    #Container {
        background-color: #423121;
        border: 2px solid #5f5242;
        margin: 100px auto;
        padding: 4px;
        width: 520px;
    }
    
    #Title {
        color: #dcd3b6;
        font-weight: bold;
        font-size: 24px;
    }
    
    #Description {
        color: #908070;
        font-size: 18px;
    }
    
    #Description p {
        text-indent: 20px;
        margin: 4px;
        text-align: justify;
    }

    #Logo {
        float: right;
    }
	
  </style>
 </head>
 <body>
 
  <div id="Container">
   <div id="Title">Welcome to the leaf framework!</div>
   <div id="Description">
    <img src="/leaf/content/leaf/leaf-logo.png" id="Logo" alt="leaf framework logo" />
    <p>This means, that you have installed successfuly the framework and 
    you are now able to use it to it`s full extend!</p>
    <p>For starters, we recommend reading the Userguides, distributed 
    with the package and taking a look at the <i>"WelcomeApp"</i> under 
    the <i>"applications"</i> directory.</p>
   </div>
  </div>

 </body>
</html>
