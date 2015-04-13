<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>National Science Olympaid</title>

<link rel="stylesheet" type="text/css" href="reset.css">
</style>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</style>
<script  type="text/javascript" src="Newjscript.js">   
</script>
</head>
<?php   include('connect.php');
   
    require('function.php');
  if(isset($_GET['qno']))
    {
        $qno=trim($_GET['qno']);
            
    }
    else
    {
        $qno=0;
    }
 
	$i=0;
    $i=noOfGroup();
  
 
		$database="question"; 
		$database=fetchDatabaseToIndex();  

 
   
?>
<body>
	

	<div class="wrapper">
		<div class="main_header">
			<div class="event_image">
				<img src="event_images/Logo_NCO_final.jpg" alt="BrushUp Online">
			</div>
			<div class="title_wrapper">
				<div class="title">First Inter School ICT Quiz Contest 2071</div>
				<div class="title_hilighter"></div>

			</div>
		
		</div>
		<!--------------- END OF MAIN BANNER------ -->
		
	<div class="content_wrapper_main">
	<div class="first_div_wrapper">
		  <div class="question_display_div"><h3>Question: </h3>
		        <?php 
		        if(!$qno)
                    {
                    echo "<h3>no question selected.</h3> ";
                    }
                else
                    {
                        question_fetch($qno,$database);
                    }
                 ?>
             </div>
		<div class="first_second_div">  
		        <!---- Timmer div starts here----- -->
		        <div class="timer_wrapper">
		            <div id="clock">
		            <input type="button" id="cntdwn" value="00" /> 
   
						<input type="button" id="start"name="start" onclick="Start()" value="Start" />
						<input type="button" id="pr" name="resume" onclick="resume()" value="Pause"/> 
             

		          </div>   
		        </div>  
		        
		         
			
		</div>
		</div>
		<div class="bottom_div">
			 <div class="bottom_separator"></div>
			 <div class="bottom_container">
				<div class="score_board">
		      		 		        
		          <?php groupName_fetch();?>
		        
		        <!------function that display the group Name , college Name, points and controls-->
		        </div>
		        <div class="roundNquestionNumbers_wrapper">
				   <div class="roundDetails">
						<?php
							roundDetails($qno,$i);
						?>
					</div>
					<!-- content_wrapper ends here------ -->
					<div class="question_numbers"><h3>available questions</h3>

						<?php qnos_fetch($database);?>

					</div>	
				</div>	
				
				<div class="question_control">
             
                 	<?php questionControl($i);
               
                    timerValueset($i); 
                 	?>
                 
                   </div>    
		</div>
		</div>
			
		
	</div>
		<!------- footer div starts  here----- -->
		<div class="footer">
		    <div class="bottom_separator"></div>
		    <div class="footer_container">
		    	<div class="footer_image">
		    			<div class="organiser_text">Organised By:</div>
		    			<img src="event_images/Logo_Brush-Up.JPG" alt="BrushUp Online">
		    	</div>
		    	
		    		<div class="support_text">Software By:</div>
		    		<div class="supportByImage">
		    			<img src="event_images/osac1.png" alt="OSAC">
		    		</div>
		    	
		    </div>
		     <div class="bottom_separator"></div>
		</div>
		<!------- footer div ends  here----- -->
		</div>
		<!------ wrapper div ends here----- -->

</body>	
</html>
	
	
	
	
	
	
	
	
	
	
	<!----------------------------------------
	Contributors
	Tapan B.K.    		contact Number 9849716660
	Abhash Adhikari 	contact Number 9841099718
	
	you can contact to above above number for more support or help
	
	This application is free to use and distribute without the permission of cintributors
	But the above contributors info must not be removed
	
	--------------------------------------->