<script type="text/javascript">
  			var secs = 20; 
 
			</script>
<?php


/*-------------find out the number of groups in round ------*/
function noOfGroup()
{
	    global $con;
	    $query="SELECT groupName FROM groupdata";
            $res=mysql_query($query,$con);
            $i=0;
        if($res)
        {
            while($row=mysql_fetch_array($res))
			{           
            	$i++;
            
            }
              
        }
return $i;

}

/*---------------function to set the timer starts here--------------*/
function timerValueset($i)
{

					global $con;
					$query="SELECT passed FROM rounddb";
					$res=mysql_query($query,$con);
					if($res)
					{
						while($row=mysql_fetch_array($res))
						{
							$passed=$row['passed'];
						
						}
					}
					
		if($passed>=1)
			{

				?>
				<script type="text/javascript">
					var secs = 10; 
				</script>
		<?php	
    		}
}



/*----------------------funtion to set the timer value ends here------------------*/

function fetchDatabaseToIndex() 
{
	global $con;
	$query="select db from rounddb";
	$res=mysql_query($query,$con);
	if($res)
	{
		while($row=mysql_fetch_array($res))
		{
		$database=$row['db'];
		}
		
	}
	if(!$res)
	{
	echo "error fetching database name for question";
	}

	return $database;
	
}



function qnos_fetch($database)
{
    global $con;
    
    if(isset($_GET['qno']))
    {    
        $qno=trim($_GET['qno']);
        $query="UPDATE  $database SET flag=1 WHERE qno='$qno'";
        $res=mysql_query($query,$con);
        if(!$res)
            {
              echo "flag set unsuccessful";
            }           

}
			          
          
$query="SELECT qfrom,qto FROM tempdb";

$res=mysql_query($query,$con);
if($res)
{
    while($row=mysql_fetch_array($res))
    {
        $qfrom=$row['qfrom'];
        $qto=$row['qto'];
       
    }
}

$query="SELECT * from  $database where qno between $qfrom and $qto";
$res = mysql_query($query);
$noq = mysql_num_rows($res);
        $i=1;
        
        ?>
        
        <table><tr>
        <?php
      while($row = mysql_fetch_assoc($res))
      {
        $temp[$i]=$row['qno'];
        $flag[$i]=$row['flag'];
        $i++;
      } 
       ?>
 
          <?php  
            $count=1;
            $no=1;
          for($i=1;$i<=$noq;$i++)
          {
              if(!$flag[$i])
                 {
                 
                 ?>
                <td><a href="index.php?qno=<?php echo $temp[$i];?>"><?php  echo $i;?></a></td>
                  <?php
                  $no=0;
                  if(($count%5)==0)
                 {
                     echo "</tr><tr>";
                 }
                  $count++;
                
                 }
             }
             if($no)
             {
             echo "<br><h3>No questions available</h3>";
             }
    		?>
    		
    	</tr></table>	
    		<?php
    
}

/*--------- question numbers fetch query endss here------*/






/*--------- question  fetch query starts here-----------*/

function question_fetch($qno,$database)
{
      if(isset($_POST['nextQues']))
	  {
   	 			echo "<div class='chooseRequest'>";
                echo "please choose the question from available questions..";
                echo "</div>";
    
    	}
    else
	{
    	
		global $con;
		$query="SELECT question FROM  $database where qno=$qno";
		$res=mysql_query($query,$con);
		if($res)
		{
			while($row=mysql_fetch_array($res))
			{
					$question=$row['question'];
			}
		}

		$exetn= strchr($question,'.');
		if($exetn=='.jpg'||$exetn=='.jpeg'||$exetn=='.png')
		{
		?>
		<div class='question_display'>

		<a href="images/<?php echo $database;?>/<?php echo $question;?>" target="_blank">
		<img src="images/<?php echo $database;?>/<?php echo $question;?>" alt="picture"  height="205" ></a>
		
		
		</div>
		<?php
		}
		else
		{
			  	echo "<div class='question_display'>";
                echo $question;
                echo "</div>";
		
		
		}

		}
    
	
    
       if(isset($_POST['checkAnswer']))
   {
            
               $answer="no answer found!!";
               $qno=trim($_GET['qno']);
               $query="SELECT answer FROM  $database WHERE qno=$qno";
               $res=mysql_query($query,$con);
               if($res)
               {
                   while($row=mysql_fetch_array($res))
                   {
                       $answer=$row['answer'];
                   }
               }
               
               
               
                echo "<div class='answer_display'>";
                echo "Answer: ".$answer;
                echo"</div>";
            
   } 
}



/*------question_fetch function ends here -------------*/
/*------group Name fetch function ends here -------------*/




function groupName_fetch()
{
          global $con; 
       	$query="select currentgroup from rounddb";
        $res=mysql_query($query,$con);
        if($res)
		{
       		while($row=mysql_fetch_array($res))
			{
       			$currentgroup=$row['currentgroup'];
       		}
       
       	}
       	if(!$res)
		{
       	echo "error";
       }
       
           $points=0;
           if(isset($_POST['10point']))
           {
               $points=10;  
           }
             
             if(isset($_POST['5point']))
           {
               $points=5;  
           }
             
             if(isset($_POST['-5point']))
           {
               $points=-5;  
           }
             $query="SELECT groupName,points FROM groupdata";
            $res=mysql_query($query,$con);
            if($res)
            {
        
                while($row=mysql_fetch_array($res))
                {
                    if($currentgroup==($row['groupName']))
                    {
                        $points=$points+$row['points'];
                        
                    }
                }
            }
            
           
            $query="update groupdata SET points='$points' WHERE groupName='$currentgroup'";
                        $res=mysql_query($query);
                        if(!$res)
                            {
                                echo mysql_error();
                            }    
             ?>
      
        <table border="1px">
        <tr>
                <th>Group</th>
                <th colspan="4">School Name</th>
                <th>Points</th>
            
            </tr><tr>
            <?php
            $query="SELECT groupName,school,points FROM groupdata ORDER BY groupName";
            $res=mysql_query($query,$con);
        if($res)
        {
            while($row=mysql_fetch_array($res))
            {
            ?>
                <td><?php echo $row['groupName'];?></td> 
                      <td colspan="4"><?php echo $row['school'];?></td>
                      <td><?php echo $row['points'];?></td> 
                </tr>          
          <?php
           
            }
              
        }
        
         ?>
            </table>  
            <form method="POST" action="">
                <input type="submit" name="10point" value="10 POINTS">
                <input type="submit" name="5point" value="5 POINTS">
                <input type="submit" name="-5point" value="-5 POINTS">
                
            </form>
               
<?php
}




/*------------------points update with the group Name and school name ends here-----------*/


function questionControl($i)
    {
        ?>
        <form method="POST" action="">
            
             <?php
             global $con;
             $query="SELECT passed FROM rounddb";
			$res=mysql_query($query,$con);
			if($res)
			{
				while($row=mysql_fetch_array($res))
				{
					$passed=$row['passed'];

				}
			}
            
            	 
            	 if($passed==$i-1)
				{
            
					 ?>
					 <input type="submit" name="passQues" id="Audience" value="Pass Question" onClick="AudienceWarn()">
					<?php 
            	}
            	 else
				{
            	 
            	 ?>
            	 
            	 <input type="submit" name="passQues" id="nextPass" value="Pass Question" onClick="passed()">
			
            	<?php 
				 }	 
            ?>
             <input type="submit" name="nextQues" value="Next Question">
             <input type="submit" name="checkAnswer" id="AnswerShow" value="Show Answer" >
            
<p id="demo"></p>

         </form>
        <?php    
    }

/*---------------function to display the details about the round--------*/
function roundDetails($qno,$i)
{




/*----------------UPDATING THE CURRENT GROUP AND START GROUP STARTS HERE---------------- */
    
    
    
    
     global $con;
    $query="SELECT groupName FROM groupdata ORDER BY groupName ASC";
    $res=mysql_query($query,$con);
    if($res)
	{
    	while($row=mysql_fetch_array($res))
		{
    		$lastGroup=$row['groupName'];
    	}
    }
      
    $query="SELECT startgroup,currentgroup,flag,passed from rounddb";
    $res=mysql_query($query,$con);
    if($res)
    {
        while($row=mysql_fetch_array($res))
        {
            $startGroup=$row['startgroup'];
            $currentGroup=$row['currentgroup'];
            $flag=$row['flag']; 
            $passed=$row['passed'];   
      
        }
        
    }
    
    
    if(!$res)
    {
     echo "error fetching the data from the group:";
    }



   
 if(isset($_POST['passQues']))
 {
			if($passed>0)
			{
				?>
				<script type="text/javascript">
					var secs = 10; 
				</script>
		<?php	
    		}
    
    
    if($passed<$i)
    {         
         if($flag)
         {
             if($currentGroup==$lastGroup)
             {
					$currentGroup='A';
             }
             else
             {
            	$currentGroup=chr(ord($currentGroup)+1);
             }
         }
         else
         {
             if($currentGroup=='A')
             {
                 $currentGroup=$lastGroup;
             }
             else
             {
                $currentGroup=chr(ord($currentGroup)-1);
             }
         }  
         
         $passed++; 
        $query="UPDATE rounddb SET currentgroup='$currentGroup'";
        $res=mysql_query($query);
        if(!$res)
            {
              echo mysql_error();
              echo "error updating the current group";  
            }
           
        $query="UPDATE rounddb SET passed='$passed'";
        $res=mysql_query($query);
        if(!$res)
            {
              echo mysql_error();
              echo "error updating the current group";  
            }    
    }
    else
    {
  
     $query="UPDATE rounddb SET passed=0";
        $res=mysql_query($query);
        if(!$res)
            {
              echo mysql_error();
              echo "error updating the current group";  
            } 
    
    } 
 }
     
     
     if(isset($_POST['nextQues']))
     {
                 
         if($flag)
         {
             if($startGroup==$lastGroup)
             {
                  $startGroup=chr(ord($startGroup));
                 $flag=0;
             }
             else
             {
            $startGroup=chr(ord($startGroup)+1);
             }
         }
         else
         {
             if($startGroup=='A')
             {
                 $flag=1;
                $startGroup=chr(ord($startGroup));
             }
             else
             {
                $startGroup=chr(ord($startGroup)-1);
             }
         }
         
        
         $currentGroup=$startGroup;
       
        $query="UPDATE rounddb SET startgroup='$startGroup' ";
        $res=mysql_query($query);
        if(!$res)
        {
        echo "error updating the start group !!";
        echo mysql_error();
        }


        $query="UPDATE rounddb SET currentgroup='$currentGroup',flag='$flag',passed=0 ";
        $res=mysql_query($query);
        if(!$res)
        {
        
        echo mysql_error();
        }
        
       
     }




/*----------------UPDATING THE CURRENT GROUP AND START GROUP ENDS HERE---------------- */

/*--------------For obtaining the Round Name from DB----------------*/
$query="SELECT roundName FROM tempdb ";
$res=mysql_query($query,$con);
if($res)
{
    while($row=mysql_fetch_array($res))
    {
        $roundName=$row['roundName'];
    }
}
else
{
    echo "UNKNOWN";
}


$query="SELECT currentgroup,startgroup,passed FROM rounddb";
$res=mysql_query($query,$con);
if($res)
{
    while($row=mysql_fetch_array($res))
    {
        $askedto=$row['startgroup'];
        $passedto=$row['currentgroup'];
        $passed=$row['passed'];
      
        
    }
}


$query="SELECT school FROM groupdata  WHERE groupName='$askedto'";
$res=mysql_query($query,$con);
if($res)
{
    while($row=mysql_fetch_array($res))
    {
        
        $askedto=$row['school'];      
    }
}
     
        
$query="SELECT school FROM groupdata  WHERE groupName='$passedto'";
$res=mysql_query($query,$con);
if($res)
{
    while($row=mysql_fetch_array($res))
    {
        
        $passedto=$row['school'];      
    }
}

?>


<table>
<tr>
    <td>Round </td><td><?php echo $roundName;?></td>
</tr>

<tr>
    <td>Q.No.</td><td><?php echo $qno; ?>   </td>
</tr>

<tr>
    <td>Asked To</td><td><?php echo $askedto; ?></td>
</tr>
<tr>
    <td>Passed To</td><td><?php echo $passed; ?> Times  </td>
</tr>

<tr>
    <td>Turn </td><td><?php echo $passedto;?> </td>
</tr>
</table>


<?php
}





/*-------------------------for processing data from admin.php file --------------------------- */

/*-------- to set the questions to a new round -----------*/
/*----- to set the round name, qnumber start from and qnumber end for a round-------*/

function roundSet($database)
{

    if(isset($_POST['newRoundSubmit']))
    {
        global $con;
        $roundName=ucwords(strtolower(trim($_POST['roundName'])));
        $qfrom=trim($_POST['qfrom']);
        $qto=trim($_POST['qto']);
        $query="update tempdb SET qfrom='$qfrom',qto='$qto',roundName='$roundName'";
        $res=mysql_query($query,$con);
        if(!$res)
        {
            echo mysql_error();
        }
        else
        {
            $query="update  $database SET flag=0 where qno between $qfrom AND $qto";
            $res=mysql_query($query);
            $res=mysql_query($query,$con);
            if(!$res)
            {
                echo "error in updating the flag";
            }
        }
        
        $query="update rounddb SET startgroup='A',currentgroup='A',flag='1',passed='0'";
        $res=mysql_query($query,$con);
        if(!$res)
        {
            echo mysql_error();
        }

    }
     
    ?>
    <fieldset >
        <legend>New round </legend>
        <form action="" method="POST" >
        <table>
            <tr>
                <td>Round name</td>
                <td> : <input type="text" name="roundName" required></td>
            </tr>
            <tr>
                <td>Question Start  </td>
                <td> : <input type="number" name="qfrom" required > </td>
            </tr>
            <tr>
                <td> Question End </td>
                <td> : <input type="number" name ="qto" required> </td>
            </tr>
            <tr>   
            <td></td><td>
                <input type="submit" name="newRoundSubmit" value="Insert" >
            </td>
            </tr>
        </table>  
        </form>
        </fieldset>

    <?php
    
}

/*------------------------------------------------------*/

/*----- function for new question insert div-------*/
/*---------------function to insert a new question----------------------*/
function newQuestionInsert($database)
{
   
    if(isset($_POST['newQuestionSubmit']))
    {
        global $con;
        $sn=trim($_POST['sn']);
        $ques=trim($_POST['ques']);
        $ans=trim($_POST['ans']);

            $query="SELECT qno from the WHERE id='$sn'";
            $res=mysql_query($query,$con);
            if($res)
            {
                while($row=mysql_fetch_array($res))
                {
                    $qno=$row['qno'];    
                }
                if($qno==$sn)
                {
                    $query="UPDATE  $database SET question='$ques',answer='$ans'";
                    $res=mysql_query($query,$con);
                    if(!$res)
                    {
                        echo "updating the question";
                    }
                }
            
            
            }
            else
            {
             
            $query = "DELETE FROM  $database WHERE qno=$sn";
            $res = mysql_query($query,$con);            
            $query = "INSERT INTO $database (qno,question,answer) VALUES ('$sn','$ques','$ans')";
                if (!mysql_query($query,$con))
                {
                    echo "unsuccessful".mysql_error();
                }    
            }
                  
                
    }
    ?>
            <fieldset >
            <legend>Insert New question / Update</legend>
            <form action="" method="POST" >
            <table>
                <tr><td> SN. </td><td>: <input type="number" name="sn" required></td></tr>
                <tr><td>Question </td><td>: <input type="text" name="ques" required > </td></tr>
                <tr><td>Answer </td><td>: <input type="text" name="ans" required> </td></tr>
                <tr><td><input type="submit" name="newQuestionSubmit" value="Insert" ></td></tr>
            </table>
            </form>
           
        </fieldset> 
<?php
    
}

/*---------------function to insert a new question ends here----------------------*/

/*-----------the function definition for view question answer starts here ---------*/
function  view_question_answer($database)
{    
    ?>
    <fieldset >
            <legend>View Question With answer</legend>
                <form action="" method="POST" >
                S.N.: <input type="number" name="sn" > <input type="submit" value="View" name="viewQuestionNanswer" >
            
        </form>
       
<?php
    
        if(isset($_POST['viewQuestionNanswer']))
    {
        global $con;
        $sn=trim($_POST['sn']);
        $query="SELECT question,answer FROM  $database WHERE qno=$sn";
        $res=mysql_query($query,$con);
        if($res)
            {
            while($row=mysql_fetch_array($res))
                {
                echo "<b>Question :</b>".$row['question']."<br>";
                   echo "<b>answer :</b>" .$row['answer'];
                }
                
            }
           
    }
    ?>
     </fieldset> 
     <?php
    
}




/*----------------------view question with answer ends here ----------------------*/

/*---------------select round database for the current round----------------------*/

function select_round_database()
{
?>
		 <fieldset >
            <legend>select database for the round</legend>
		<form action="" method="POST">
			<select name="Round" class="select" class="round">
			<option value="qualifying">Qualifying</option>
			<option value="semiFinal">Semi-final</option>
			<option value="final">Final</option>
			</select>
			
			<br>
			<select name="subRound" class="round">
				<option value="Game1">Game1</option>
				<option value="Game2">Game2</option>
				<option value="Game3">Game3</option>
				<option value="Game4">Game4</option>
				<option value="Game5">Game5</option>
				<option value="Game6">Game6</option>
				<option value="Game7">Game7</option>
				<option value="Game8">Game8</option>
			</select><br>
			<input type="submit" value="OK" name="roundOK">
			</form>
			
		<?php
		$round="unknown";
		$subRound="Unknown";
		if(isset($_POST['Round']))
		{
			$round=$_POST['Round'];
		}
		if(isset($_POST['subRound']))	
		{
			$subRound=$_POST['subRound'];
		}
		global $con;
		if(isset($_POST['roundOK']))
			{
				
				$completeRoundDB=$round.$subRound;
				$query="select * from $completeRoundDB";
				$res=mysql_query($query,$con);
				if($res)
				{
					$completeRoundDB=$round.$subRound;
				}

				else
				{
					$completeRoundDB="question";
					echo "default Database (question) is selected.";
					
				}
				
				$query="update rounddb set db='$completeRoundDB'";
				$res=mysql_query($query,$con);
				if(!$res)
					{
						echo "error in updating the round database.";
					}
				
			}
				
			?>
		</fieldset>	
		<?php
}


/*---------------select round database for the current round ends here----------------------*/
/*----------------------correct the group score starts here ----------------------*/
function correctScore()
{
    if(isset($_POST['changescore']))
    {
        global $con;
        $groupSymbol=strtoupper(trim($_POST['groupSymbol']));
        $groupScore=trim($_POST['score']);
        $query="UPDATE groupdata SET points='$groupScore' WHERE groupName='$groupSymbol'";
        $res=mysql_query($query,$con);
        if(!$res)
        {
            echo "unsuccessful";
        }
    }

   
    ?>
    
    <fieldset >
    <legend> Correct Score</legend>
        <form action="" method="POST">
            <table>
                <tr>
                    <td>Group(symbol)</td>
                    <td>: <input type="text" name="groupSymbol" ></td>
                </tr>
                <tr>
                    <td>Score</td>
                    <td>: <input type="number" name="score" ></td>
                </tr>
                <tr>
                    
                    <td><input type="submit" id="chd_gs" name="changescore" value="Change" ></td>
                </tr> 
            </table>
        </form>    
    </fieldset> 
<?php
  
}

/*----------------------correct the group score starts here ----------------------*/






/*-------------------function definition to change the group data starts here ---------------*/
   function changeGroupData()
    {
        if(isset($_POST['newGsubmit']))
        {
            global $con;
            $GSymbol=strtoupper(trim($_POST['Gsymbol']));
            $Sname=ucwords(strtolower(trim($_POST['Sname'])));
            $score=trim($_POST['score']);
            $query="UPDATE groupdata SET  school='$Sname',points='$score' WHERE groupName='$GSymbol' ";
            $res=mysql_query($query,$con);
            $result=mysql_affected_rows();
            
            if(!$result)
            {
         
                $query="INSERT INTO groupdata (groupName,school,points) VALUES('$GSymbol','$Sname','$score')";
                $res=mysql_query($query,$con);
                if(!$res)
				{
            		echo "error";
            	}
            }
           
        }
        ?>
        <fieldset>
        <legend>Change Group Data </legend>
        <form action="" method="POST" >
    	<table>
            <tr>  
					<td> Group Symbol :</td>
					<td><input type="text" name='Gsymbol' > </td>
           	</tr>
            <tr>
					<td>School Name :</td>
					<td><input type="text"  name='Sname' ></td>
            </tr>
           <tr>
					<td>Score :</td>
					<td><input type="number" name='score'  value=0></td>
            </tr>
           	<tr>
					<td><input type="submit" name="newGsubmit" value="Insert" ></td>
			</tr> 
           </table>
        </form>
        </fieldset>
        <?php
   }    

/*-------------------function definition to change the group data ends here ---------------*/



/*-------------------------------clear all function starts here--------------------------*/
   function clearAll($database)
   {

  global $con;
/*--------------------clear the question asked for the round starts here---------------------*/     
    if(isset($_POST['ClearQasked']))
   {
       
      clearQAsked();
      
       
   }
   
/*--------------------clear the question asked for the round ends here---------------------*/   


  /*----------------clear the groupdata starts here-------------------------*/ 
   
    if(isset($_POST['ClearGdata']))
   {
        clearGdata();
    }
    
    
/*----------------clear the groupdata starts here-------------------------*/    


/*----------------clear the Round data starts here-------------------------*/    
   
   if(isset($_POST['ClearRdata']))
   {
       
       roundRData();
       
       
   }
/*----------------clear the Round data ends here-------------------------*/  




            
/*----------------clear the factory reset except the database starts here-------------------------*/    
   
   if(isset($_POST['FactoryDS']))
   {
        clearQAsked();
        clearGdata();
        roundRData();
   }
   
/*----------------clear the factory reset except the database ends here-------------------------*/


/*----------------clear the factory reset all the database starts here-------------------------*/
if(isset($_POST['FactoryDefault']))
{
        clearQAsked();
        clearGdata();
        roundRData();
        deleteAllquestion($database);
}

/*----------------clear the factory reset all the database ends here-------------------------*/

   ?>
       <fieldset>
       <legend> clear all</legend>
            <form action="" method="POST" >
            <input type="submit" name="ClearQasked" value="Remove Current Round Question " title="set numbers of question set to asked to 0 and round to UNKNOWN" >
            <input type ="submit" name="ClearGdata" value="Clear Current group details with points" title="delete all the school name and set school name to default and respective point to 0" >
            <input type="submit" name="ClearRdata" value="reset Round" title="Sets current group and Start group to A and question database to default database Question ">
            <input type="submit"   name="FactoryDS" value="Clean All Except qna Database" title="clear all the above option">
            <input type="submit" name="FactoryDefault" id="FactoryDD" value="Factory Default" onClick="warn()" title="ALert!!! clear all the above and current database question">
        </fieldset>
    
<?php
   
   
   }
   
/*-------function definition of various function obtained from clear all function starts here----*/   
   
   function clearQAsked()
   {
   
      global $con;
       $query="UPDATE tempdb SET qfrom=0,qto=0,roundName='UNKNOWN'";
       $res=mysql_query($query,$con);
       if($res)
       {
           echo mysql_error();
       }
   }
   
  
   
    
     
       function clearGdata()
   {
            
        global $con;
       
       $query="DELETE FROM groupdata";
       $res=mysql_query($query,$con);
        if(!$res)
        {
            echo mysql_error();
        }
        else
        {
        $query="INSERT INTO groupdata (id,groupName,school,points) 
                VALUES (1, 'A', 'AB', 0),
                        (2, 'B', 'BC', 0),
                        (3, 'C', 'CD', 0)";
            $res=mysql_query($query,$con);
            if(!$res)
            {
                echo mysql_error();
            }            
        
        }  
   
   }
   
  /*--------------clear the round date starts here----------------*/   
   function roundRData()
   {
        global $con;
       $query="UPDATE rounddb SET startgroup='A',currentgroup='A',flag=1,passed=0,db='question'";
       $res=mysql_query($query);
       if(!$res)
       {
           echo mysql_error();
       }
    }
    
     
/*--------------clear the round date ends here----------------*/   



/*--------------clear the all the questions in the database starts here----------------*/   

function deleteAllquestion($database)
        {
            global $con;
            $query="DELETE FROM  $database";
            $res=mysql_query($query,$con);
            if(!$res)
            {
                echo mysql_error();
            }
            else
            {
                $query="INSERT INTO  $database (qno,question,answer,flag) VALUES(1,'This is the test question?','TEST')";
                if(!$res)
                {
                    echo mysql_error();
                }
            }
        }

/*--------------clear the all the questions in the database ends here----------------*/   
         
     
   /*-------function definition of various function obtained from clear all function ends here----*/  
   

/*-------------------------------factory default setting ends here--------------------------*/


?>
