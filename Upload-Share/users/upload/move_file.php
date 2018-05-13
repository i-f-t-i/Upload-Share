
<?php 

$abs_us_root=$_SERVER['DOCUMENT_ROOT'];

$self_path=explode("/", $_SERVER['PHP_SELF']);
$self_path_length=count($self_path);
$file_found=FALSE;

for($i = 1; $i < $self_path_length; $i++){
	array_splice($self_path, $self_path_length-$i, $i);
	$us_url_root=implode("/",$self_path)."/";
	
	if (file_exists($abs_us_root.$us_url_root.'z_us_root.php')){
		$file_found=TRUE;
		break;
	}else{
		$file_found=FALSE;
	}
}

require_once $abs_us_root.$us_url_root.'users/init.php';
  
  ?>


<?php require_once $abs_us_root.$us_url_root.'users/includes/custom_header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/custom_navigation.php'; ?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
//dealing with if the user is logged in
if($user->isLoggedIn() || !$user->isLoggedIn() && !checkMenu(2,$user->data()->id)){
	if (($settings->site_offline==1) && (!in_array($user->data()->id, $master_account)) && ($currentPage != 'login.php') && ($currentPage != 'maintenance.php')){
		$user->logout();
		Redirect::to($us_url_root.'users/maintenance.php');
	}
}

$grav = get_gravatar(strtolower(trim($user->data()->email)));
$get_info_id = $user->data()->id;
// $groupname = ucfirst($loggedInUser->title);
$raw = date_parse($user->data()->join_date);
$signupdate = $raw['month']."/".$raw['day']."/".$raw['year'];
$userdetails = fetchUserDetails(NULL, NULL, $get_info_id); //Fetch user details

?>



<?php
    

 if (isset($_POST['formSubmit']))

   {

if($_POST['formSubmit'] == "Submit") 


    {

       $fileName = $_POST['upload'];

       $fileNo = $_POST['no'];


           $db2 = DB::getInstance();


                   $user_no_info = $user->data()->id; 

        //getting upload no from upload

 $query1 = $db2->query("SELECT * FROM file WHERE file_name='".$fileName."' AND user_no='".$user_no_info."'"); 

  $x1 = $query1->results(true);

    foreach ($x1 as $value1)

                {
                   $catNo = $value1[no];
                   break;
                }




 $query = $db2->query("UPDATE category SET category=? WHERE no=?",array($catNo,$fileNo)); 

  $query->results();

  header("Location: upload.php?upload=".$fileName."");



    }

   }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Move File</title>
  <meta charset="utf-8">
</head>
<body>

    
<div id="page-wrapper">
<div class="container">
<div class="well">
<div class="row">

    <?php
    	    if(!empty($errorMessage)) 
		    {
			    echo("<p>There was an error with your form:</p>\n");
			    echo("<ul>" . $errorMessage . "</ul>\n");
         
            }
   ?>

   <p><br></p>
  <h2>Move Image</h2>
  <form class="form-horizontal" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">

      <?php
          
     $getValue = $_GET ['fileno'];

      ?>

       <input type="hidden" id="no" name="no" value="<?php echo($getValue);  ?>">

      <div class="form-group">
  <label class="col-sm-2 control-label">Move File to Upload Folder</label>
 <div class="col-sm-10">
    <select class="form-control" id="upload"  name ="upload" >

         <?php
                
                

 $db = DB::getInstance(); 

$query = $db->query("SELECT file_name FROM file WHERE user_no='".$user_no_info."'"); 

$x = $query->results(true);


                
               foreach ($x as $value)
                {


                    echo("<option>" . $value[file_name] . "</option>");


                }
          
            

            ?>
   
   
  </select>

</div>
</div>
<div class="form-group"> 
    <div class="col-sm-10">

        <button type="submit" name="formSubmit" value="Submit" class="btn btn-primary">Move</button>


        
  </div>
   </div> 
              
  </form>



    </div> <!-- /.col -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</div> <!-- /.wrapper -->


     <!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>


   

</body>
</html>
