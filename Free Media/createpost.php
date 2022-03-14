<?php 
include('db.php');
require_once("useful.php");
session_start();
LoginCheck();

 $user_tag = $_SESSION['USER_DATA']['ID'];
 $file_url=NULL;
 $priv = $_SESSION['USER_DATA']['PRIV'];
 $x=$_SESSION['USER_DATA']['STATUS'];
?>


<?php
  if($x=='reader'||$x=='admin')
  {
    header("Location: notallowed.php");
  }
?>


<?php
  if($priv!=1)
  {
    header("Location: error.php");
  }
?>


<?php 
// submit new post 
if (isset($_POST['submit'])) {

    $blog_tag=$_POST['blog_tag'];
    $title=$_POST['title'];
    $text=$_POST['text'];
    $text = mysqli_real_escape_string($connection, $text);
    $title= mysqli_real_escape_string($connection, $title);
    
    $length1= strlen($title);
    $length2=strlen($text);

    echo $length1;
    echo $length2;
    if( $length1==0 ||$length2==0 )
        {

          header("Location: no.php");
        }


    $pfiles=$_FILES['pfiles'];

    if( count($pfiles['name'])!=0){
      
     
      for($i=0;$i<1;$i++)
      {
          $target_file=$pfiles['tmp_name'][$i];
          $file_type = $pfiles['type'][$i];
          
          if($file_type != "image/jpg" 
          && $file_type != "image/png" 
          && $file_type != "image/jpeg" 
          && $file_type != "image/gif" 
         ) 
          {
              echo "<h1>Sorry, you have eitgher not submitted any file or your submitted file is not supported. Only JPG, JPEG, PNG & GIF files are allowed.</h1>";
              echo "<div><p>You are uploading <strong>$file_type </strong>file</p></div>";

          }
          else{
              $file_name=$pfiles['name'][$i];
              $file_url='./media/'.$file_name;
              move_uploaded_file($target_file,$file_url);
              
    
              
          }
      }


  } 




 








    $sql = "INSERT INTO post (Title,Text,User_Tag,blog_tag,Link) VALUES('$title','$text','$user_tag','$blog_tag','$file_url')";
    if (mysqli_query($connection, $sql)) {
        echo "<h3>Your blog has been posted.";
        header("Location: cp.php");

    } else {
        echo "ERROR! wasn't posted please try again <br>" . mysqli_error($connection);
    }
   
    mysqli_close($connection);

    //header("Location: explore.php");
    die;

}

?>







<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
 
    <title>Create Post</title>
    <style>
    sup{
  color:#FF0000;
}

        .error {
            color: #FF0000;
        }


        body{
            font-family:  Copperplate, Papyrus, fantasy;
            background-color:#CE4F33;
            background-image: url('g1.jpg');
            background-repeat: repeat-x ;
            background-color:#0099ff;
             background-size: cover;
        }



    </style>
  </head>



  <body>
  <?php
include('beautify.php'); ?>
   

  <?php 
include './navb.php';
?>


  <b>
   <div class="container" style="background-color:rgba(206, 79, 51, 0.7);">
   <h1 align="center" style="font-family:  Copperplate, Papyrus, fantasy;background-color:#CE4F33;"> Create your blog! </H1> 

  
        <div class="card" style="background-color:rgba(206, 79, 51, 0.5);">
        <div class="card-body" style="background-color:rgba(206, 79, 51, 0.5);">
        <form action="" method="post" class="needs-validation"     enctype="multipart/form-data">
            <!-- select community -->
            <div class="row mb-3" style="background-color:rgba(206, 79, 51, 0.5);">
                <div class="col-sm-4" style="background-color:rgba(206, 79, 51, 0.5);">
                    <label for="comm" class="form-label">Blog Type : Please select blog type. </label>
                    <select class="form-select" id="blog_tag" name="blog_tag" aria-label="Default select example">
                   
                   
 
                            <option  value="Sports"> Sports </option>";

                            <option  value="Business"> Business </option>";

                            <option  value="Fashion">Fashion </option>";
                            <option  value="Music"> Music </option>";
                            <option  value="Fitness"> Fitness </option>";
                            <option  value="Food"> Food</option>";
                            <option  value="Politics"> Politics </option>";
                            <option  value="Science"> Science </option>";
                            <option  value="IT"> IT </option>";
                            <option  value="Gaming"> Gaming </option>";

                        
                
               
                   
                    </select>
                </div>
            </div>
 
            <!-- end select community -->
            <div class="mb-3" style="background-color:rgba(206, 79, 51, 0.5);">
            <label for="posttitle" class="form-label">Title</label> 
            <input type="text" class="form-control" id="posttitle"  name="title"placeholder="" required>
            <div class="valid-feedback" style="background-color:rgba(206, 79, 51, 0.5);">Valid.</div>
              <div class="invalid-feedback" style="background-color:rgba(206, 79, 51, 0.5);">Please fill out this field.</div>
            </div>
                    </b>
            <div class="mb-3" style="background-color:rgba(206, 79, 51, 0.5);">
            <label for="exampleFormControlTextarea1" class="form-label"> <b>Text</b></label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="text" rows="10" required></textarea>
            <div class="valid-feedback" style="background-color:rgba(206, 79, 51, 0.5);"><b>Valid.</b></div>
              <div class="invalid-feedback" style="background-color:rgba(206, 79, 51, 0.5);"><b>Please fill out this field.</b></div>
            </div>
 
            <div class="mb-3" style="background-color:rgba(206, 79, 51, 0.5);">
            <label for="formFileMultiple" class="form-label"><b>Upload files<b></label>
            <input class="form-control" type="file" name="pfiles[]" id="formFileMultiple">
            </div>
           
            <button type="submit" class="btn btn-primary" name="submit">Post Blog</button>
          </form>
 
 
        </div>
      <!--  </div>-->
     </div>
   
 
   
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
 
   
    
  </body>
</html>