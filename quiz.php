<!DOCTYPE html>
<html>
<?php require 'config.php';
session_start(); ?>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" href="bootstrap/bootstrap.min.css">
<script src="bootstrap/jquery.min.js"></script>
<script src="bootstrap/bootstrap.min.js"></script>
<script src="timer.js"></script>
<title>Quiz</title>
</head>
<body>
<div class="container-fluid">
<div class="row justify-content-center">
<div class="title">Vajon rá jössz a helyes megoldásokra?</div>
<canvas id="canvas" width="100" height="100"
style="background-color:rgba(207, 144, 8, 0.507)">
</canvas>
<?php 															
	if (isset($_POST['click']) || isset($_GET['start'])) {
		@$_SESSION['clicks'] += 1 ;
		$c = $_SESSION['clicks'];
		if(isset($_POST['userans'])) { $userselected = $_POST['userans'];
																
		  $fetchqry2 = "UPDATE `quiz` SET `userans`='$userselected' WHERE `id`=$c-1"; 
	    $result2 = mysqli_query($con,$fetchqry2);
		}
		  
																	
 	} else {
		  $_SESSION['clicks'] = 0;
	  }
																
																
?>
</div>
<div class="row justify-content-center">
<div class="bump">
  <br>
  <form>
    <?php if($_SESSION['clicks']==0){ ?>
      <button class="button" name="start" id="start">
        <span>Indítás</span>
      </button> <?php } 
    ?>
  </form>
</div>
</div>
<div class="row justify-content-center">
<form action="" method="post">  				
<table>
      <?php if(isset($c)) {   $fetchqry = "SELECT * FROM `quiz` where id='$c'"; 
				$result=mysqli_query($con,$fetchqry);
				$num=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC); }
		  ?>
<tr><td><h3><br><?php echo @$row['que'];?></h3></td></tr> <?php if($_SESSION['clicks'] > 0 && $_SESSION['clicks'] < 6){ ?>
  <tr><td><input required type="radio" name="userans" value="<?php echo $row['option 1'];?>">&nbsp;<?php echo $row['option 1']; ?><br>
  <tr><td><input required type="radio" name="userans" value="<?php echo $row['option 2'];?>">&nbsp;<?php echo $row['option 2'];?></td></tr>
  <tr><td><input required type="radio" name="userans" value="<?php echo $row['option 3'];?>">&nbsp;<?php echo $row['option 3']; ?></td></tr>
  <tr><td><input required type="radio" name="userans" value="<?php echo $row['option 4'];?>">&nbsp;<?php echo $row['option 4']; ?><br><br><br></td></tr>
  <tr><td><button class="button3" name="click" id="next">Következő</button></td></tr> <?php }  
																	?> 
  <form>
  </div>
 <?php if($_SESSION['clicks']>5){ 
	$qry3 = "SELECT `ans`, `userans` FROM `quiz`;";
	$result3 = mysqli_query($con,$qry3);
	$storeArray = Array();
	while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
     if($row3['ans']==$row3['userans']){
		 @$_SESSION['score'] += 1 ;
	 }
}
 
 ?>

 <div class="row justify-content-center">
 <h2>Eredmény</h2>
 
 </div>
 <div class="row justify-content-center">
 <span>A helyes válaszok száma: 5\&nbsp;<?php echo $no = @$_SESSION['score']; 
 session_unset(); ?></span><br>
 </div>
 <div class="row justify-content-center">
 <span>A te pontszámod: &nbsp<?php echo $no*2; ?></span>
<?php } ?>
</div>
</div>

</body>
</html>