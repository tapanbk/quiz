<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>

<link rel="stylesheet" type="text/css" href="reset.css">
</style>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</style>
<script  type="text/javascript" src="Newjscript.js">   
</script>

</head>

<body>
        <?php include('function.php');
        include('connect.php');
        $database="question";
        $database=fetchDatabaseToIndex(); 
        
        ?>
        
        <div class="main_wrapper_admin">
        <div class="main_content_wrapper_admin">
            <div class="main_header_wrapper_admin">
                Welcome admin 
                <hr>
            </div>
            
            
<div class="overall_content_wrapper">



<div class="first_box_wrapper_admin">


                
		<!-------- The  change_round_div starts here ------->                
		<div class="change_round_div">
			<?php
			roundSet($database);
			?>
		</div>

						<!---This is end of change_round_div----->

		<div class="insert_new_question_div">
			<?php
			newQuestionInsert($database);
			?>
		 <!---This is end of insert_new_question_div----->
		</div>

                
<!---This is end of first_box_wrapper_admin----->
 </div>
         
             
              
                
<!---This is start of second_box_wrapper div----->
             
<div class="second_box_wrapper">

		  <div class="change_database">
			<?php select_round_database(); ?>    	

		</div>    


		<div class="view_question_answer">
		   <?php 
			view_question_answer($database);
			?> 

		</div>
				 <!--view_question_answer div ends here -->



 
 <!---This is end of second_box_wrapper div----->
</div>
             
             
             
             
             
             
             <!---This is start of third_box_wrapper div----->
<div class="third_box_wrapper">
    <div class="change_group_data">
   <?php     changeGroupData(); ?>
  
   </div>
    
  
                  
   <!--corect score  div starts here -->
                 
                    
<div class="correct_score">
 
 <?php
     correctScore();
 ?>
 
    <!--corect score  div ends here -->
 </div>
    
    
     
</div>
<!------------change_group_data div ends here -------------->


<!-----------------clear div starts here-------------------->
                        
<div class="fourth_div">
   <div class="clear">
         <?php   clearAll($database);?>
            </div>
</div>
        
        
<!----- overall content wrapper div ends here---->            
          
</div>

<!------- main_content_wrapper_admin div ends here---->  
</div>

<!-----------main_wrapper_admin div ---------------->
</div>

<!-------------------body ends here ---------------->
</body>
</html>
