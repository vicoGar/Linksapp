<?php

##---------------------------------------------------------------------------------------------------##
$thisfile = substr($_SERVER['PHP_SELF'], 1);
##---------------------------------------------------------------------------------------------------##
##
##  Actualizado para PHP 7.3 y MySQLi  //// VGC ////  19-mar-2020
##

$host = "localhost";
$user = "xfxcom_pcom_links_user";
$pass = "Kv8Bgc9mQG";
$db = "xfxcom_pcom_links";

$n=explode("/",$_SERVER['PHP_SELF']);
$nu=count($n)-1;
$thisfile=$n[$nu];


$connectt = mysqli_connect($host,$user,$pass);
       mysqli_select_db($connectt,$db); 
       
global $connectt;
       

$xorder = $_GET['xorder'];
$xsort  = $_GET['xsort'];
if(empty($xorder))   $xorder = "id"; 
if(empty($xsort))    $xsort  = "DESC"; 
$max = 40; //records per page
$p = $_GET['p'];
if(empty($p)) {	$p = 1;	}
$limits = ($p - 1) * $max; 






#---------------------------------------------------------------------------------------------------------------------#
if (isset($_POST['boton_add'])) {
    global $connectt;
		$kName    = $_POST['nTitulo'];
		$kURL     = $_POST['nUrl'];
		$kComment = $_POST['nComentario'];

			if($kName=='' || $kURL=='' || $kComment==''){
				 echo"<script>alert('You have empty fields');</script>";
			}else{

			$q2 = "INSERT INTO links_links (title,url,comments,timestamp, owner) VALUES ('{$kName}','{$kURL}','{$kComment}',now(),'null')";
			$result=mysqli_query($connectt,$q2);
			echo "<script>window.location='$thisfile'</script>";
			}
}
#---------------------------------------------------------------------------------------------------------------------#
if (isset($_REQUEST['del'])) {
    global $connectt;
	$p  = $_GET['page'];
	$id = $_GET['id'];


	$sql = mysqli_query($connectt,"SELECT * FROM links_links WHERE id = '$id'");
	while($r = mysqli_fetch_array($sql))
	{
		$id       = $r['id'];
		$title    = $r['title'];
		$url      = $r['url'];
		$comments = $r['comments'];
		$date     = $r['timestamp'];

        echo "
		<html>
		
		<title>My Bookmarks</title>
		<style>
			a:link     {color:#34a3d1; text-decoration: none}
			a:visited  {color:#34a3d1; text-decoration: none}
			a:active   {color:#34a3d1; text-decoration: none}
			a:hover    {color:#000000; background-color:#cccccc;}
			form { display:inline; } 
		</style>
		<body onLoad='document.xxDel.text_pass.focus()' bgcolor='#F6F6F6' >
        <center>
		<br><br><br><br><br>

		<form name='xxDel' method='POST' action='$thisfile' >
			<input type='hidden' name='boton_delete' value=''>
			<input type='hidden' name='id'    value='$id'>
			<input type='hidden' name='page'  value='$p'>
			<font face='Arial'><span style='font-size:10pt;'>
			<b>Confirm delete for:&nbsp;<a href='$url' target='_blank'>$title</a> ? 	</b></span></font>
			<input type='submit' name='boton_delete' value='Delete'>

			<input type='password' name='text_pass' size='15'>
			<font face='Arial'><span style='font-size:8pt;'>password</span></font>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' name='boton_cancel' value='Cancel'>
		</form>
	
		</center>
		";
		die();

	}		
}
#---------------------------------------------------------------------------------------------------------------------#
if (isset($_POST['boton_delete'])) {
    global $connectt;
		$id      = $_POST['id'];
		$p       = $_POST['page'];
		$pass    = $_POST['text_pass'];

	if ($pass == 'kilo'){
		$q2="DELETE FROM links_links WHERE id={$id} LIMIT 1";
    	$result=mysqli_query($connectt,$q2);
	    $ruta = $thisfile.'?p='.$p;
	    echo "<script>window.location='{$ruta}'</script>";
	}
}
#---------------------------------------------------------------------------------------------------------------------#
if (isset($_POST['boton_cancel'])) {
    global $connectt;
		$p       = $_POST['page'];
	    $ruta = $thisfile.'?p='.$p;
	    echo "<script>window.location='{$ruta}'</script>";
}

#---------------------------------------------------------------------------------------------------------------------#

if (isset($_REQUEST['edit'])) {
    global $connectt;
	$id = $_GET['id'];
	$pp = $_GET['page'];
	$sql = mysqli_query($connectt,"SELECT * FROM links_links WHERE id = '$id'");
	while($r = mysqli_fetch_array($sql))
	{
		$id       = $r['id'];
		$title    = $r['title'];
		$url      = $r['url'];
		$comments = $r['comments'];
		echo "

		
		<html>
		
		<title>My Bookmarks</title>
		<style>
			a:link     {color:#34a3d1; text-decoration: none}
			a:visited  {color:#34a3d1; text-decoration: none}
			a:active   {color:#34a3d1; text-decoration: none}
			a:hover    {color:#000000; background-color:#cccccc;}
			form { display:inline; } 
		</style>
		<body onLoad='document.xPost.nUrl.focus()' bgcolor='#F6F6F6' >

	
		
		<form name='xPost' method='POST' action='$thisfile'  >
			<input type='hidden' name='boton_edit' value=''>
			<input type='hidden' name='idd' value='$id'>
			<input type='hidden' name='page' value='$pp'>
			<font face='Arial'><span style='font-size:9pt;'><b>URL:</b></span></font>  <input type='text' name='nUrl' size='30' value='$url' style='color:black; background-color:rgb(173,203,231);' >
			<font face='Arial'><span style='font-size:9pt;'><b>Name:</b></span></font> <input type='text' name='nTitulo' size='15'  value='$title' style='color:black; background-color:rgb(173,203,231);' >
			<font face='Arial'><span style='font-size:9pt;'><b>Comments:</b></span></font>  <input type='text' name='nComentario' size='15' value='$comments'  style='color:black; background-color:rgb(173,203,231);' >
			<input type='submit' name='boton_edit' value='Update'><br>
		</form>		
			";
    }
die();
}
#---------------------------------------------------------------------------------------------------------------------#
if (isset($_POST['boton_edit'])) {
    global $connectt;
		$p        = $_POST['page'];		
		$recno    = $_REQUEST['xedit'];		
		$kid      = $_POST['idd'];		
		$kName    = $_POST['nTitulo'];
		$kURL     = $_POST['nUrl'];
		$kComment = $_POST['nComentario'];
			if($kName=='' || $kURL=='' || $kComment==''){
				 echo "Existen campos vacios";
			}else{
			$q2 = "UPDATE links_links SET title = '{$kName}', url='{$kURL}', comments = '{$kComment}' WHERE id = {$kid} LIMIT 1";
			$result=mysqli_query($connectt,$q2);
			$ruta = $thisfile.'?p='.$p;
			echo "<script>window.location='{$ruta}'</script>";
			}
}
#---------------------------------------------------------------------------------------------------------------------#
if (isset($_POST['boton_search'])) {
    global $connectt;
		$p        = 1;
		$q        = $_POST['q'];		
	    $trimmed  = trim($q); 
		if ($trimmed == ""){ echo"<script>alert('Write a word to search');</script>"; }
}
#---------------------------------------------------------------------------------------------------------------------#
if (isset($_REQUEST['sort'])) {
    global $connectt;

	$xorder = $_GET['xorder'];
	$xsort  = $_GET['xsort'];

	switch ($xsort){
		case ' ':
		  $xsort = 'DESC';
		  break;
		case 'DESC':
		  $xsort = 'ASC';
		  break;
		case 'ASC':
		  $xsort = 'DESC';
		  break;
	}
}
#---------------------------------------------------------------------------------------------------------------------#

$show = xshow($limits,$max,$p,$trimmed,$thisfile,$xorder,$xsort);



#---------------------------------------------------------------------------------------------------------------------#
function xshow($limits,$max,$p,$trimmed,$thisfile,$xorder,$xsort){
global $connectt;

            if (isset($_POST['boton_search'])) {	
				$query = "
				select * from links_links
				where (
				   id          like convert( _utf8 '%$trimmed%' using latin1 ) collate latin1_swedish_ci
				or title       like convert( _utf8 '%$trimmed%' using latin1 ) collate latin1_swedish_ci
				or url         like convert( _utf8 '%$trimmed%' using latin1 ) collate latin1_swedish_ci
				or comments    like convert( _utf8 '%$trimmed%' using latin1 ) collate latin1_swedish_ci
				or timestamp   like convert( _utf8 '%$trimmed%' using latin1 ) collate latin1_swedish_ci
				 ) 
				ORDER BY id DESC limit 0,999999999";
				$sql = mysqli_query($connectt, $query); 	
				$num_rows = mysqli_num_rows($sql);
			}else{	
		    	$query = "SELECT * FROM links_links ORDER BY ". $xorder." ". $xsort ." LIMIT ".$limits.",$max";
       			$sql = mysqli_query($connectt, $query); 	
				$num_rows = mysqli_num_rows($sql);
			}

        $myresult = $connectt->query("SELECT id FROM links_links ORDER BY id");
        $totalres = $myresult->num_rows;

		$totalpages = ceil($totalres / $max);  
				echo "
				<html>
				
				<title>My Bookmarks</title>
				<style>
					a:link     {color:#34a3d1; text-decoration: none}
					a:visited  {color:#34a3d1; text-decoration: none}
					a:active   {color:#34a3d1; text-decoration: none}
					a:hover    {color:#000000; background-color:#cccccc;}
                    form { display:inline; } 
				</style>
				<body onLoad='document.fsearch.q.focus()' bgcolor='#F6F6F6' >
				";

		echo"
		
			<form name='xName' method='POST' action='$thisfile' >
				<input type='hidden' name='boton_add' value=''>
				<font face='Arial'><span style='font-size:9pt;'><b>URL:</b></span></font>  <input type='text' name='nUrl' size='30' value='http://www.'  >
				<font face='Arial'><span style='font-size:9pt;'><b>Name:</b></span></font> <input type='text' name='nTitulo' size='15'>
				<font face='Arial'><span style='font-size:9pt;'><b>Comments:</b></span></font>  <input type='text' name='nComentario' size='15'>
				<input type='submit' name='boton_add' value='Add'>
			</form>	

			<form name='fsearch' method='POST' action='$thisfile' >
				<input type='hidden' name='boton_search' value=''>
				<input type='hidden' name='idd' value='$id'>
				<input type='hidden' name='pagesss' value='$psss'>
				<font face='Arial'><span style='font-size:9pt;'></span></font>  <input type='text' name='q' size='10' value='$q' style='color:black; background-color:rgb(173,203,231);' >
				<input type='submit' name='boton_search' value='Search'>
			</form>	

			<font face='Arial'><span style='font-size:9pt;'><a href='$thisfile'><b>Home</b></a></span></font>

			";
			echo"
			<br><br>
			";

        if (!isset($_POST['boton_search'])) {	
		  $callfunction = pagination($totalpages, $p, $i,$xorder,$xsort);
		}

		if(!empty($trimmed)) {
		   $aText = "<span style='font-size:9pt;'><font face='Arial' color='#999999'>&nbsp;Cadena de busqueda:  ". $trimmed . "  &nbsp;&nbsp;     Registros: ". $num_rows . "</font></span>";
		}else{
		   $aText = "<span style='font-size:9pt;'><font face='Arial' color='#999999'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total records: ". $totalres . "</font></span>";
		}
		   $bText = "<span style='font-size:9pt;'><font face='Arial' color='#999999'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Field: ". $xorder . " Order: " . $xsort .  " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font></span>";

		echo "

		$aText  $bText   <br>
	    <table border='0' width='900' cellpadding='4' cellspacing='1' style='border-width:1pt; border-color:rgb(129,162,196); border-style:solid;'>
		<tr>
		  <td width='100%' height='26' bgcolor='#025C95' style='border-width:1pt; border-color:rgb(129,162,196); border-style:none;' colspan='5'>
		   <p><b><font face='Arial' color='white'><span style='font-size:10pt;'><big>My Bookmarks</big> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Page  $p of $totalpages  </span></font></b></p>
		   </td>
		</tr>
		<tr>
			<td bgcolor='#ADCBE7' style='border-width:1pt; border-color:rgb(129,162,196); border-style:none;' width='316'><font face='Arial'><span style='font-size:9pt;'><b><a href='$thisfile?sort&xorder=title&xsort=$xsort&page=$p'>Title</a></b></span></font></td>
			<td bgcolor='#ADCBE7' style='border-width:1pt; border-color:rgb(129,162,196); border-style:none;'><font face='Arial'><span style='font-size:9pt;'><b><a href='$thisfile?sort&xorder=comments&xsort=$xsort&page=$p'>Comments</a></b></span></font></td>
			<td bgcolor='#ADCBE7' style='border-width:1pt; border-color:rgb(129,162,196); border-style:none;'><font face='Arial'><span style='font-size:9pt;'><b><a href='$thisfile?sort&xorder=timestamp&xsort=$xsort&page=$p'>Date</a></b></span></font></td>
			<td align='center' bgcolor='#ADCBE7' style='border-width:1pt; border-color:rgb(129,162,196); border-style:none;'> </td>
			<td bgcolor='#ADCBE7' style='border-width:1pt; border-color:rgb(129,162,196); border-style:none;'><font face='Arial'><span style='font-size:9pt;'><b>&nbsp;</b></span></font></td>
		</tr>		
		";


		$i = 0;
			while($r = mysqli_fetch_array($sql))
			{

			if($i % 2 ==0){echo"<tr bgcolor='#F4F4F4' >";}else{echo"<tr bgcolor='#EEEEEE'>";}  ## alternate colors per rows

				$id = $r['id'];
				$title     = $r['title'];
				$url       = $r['url'];
				$comments  = $r['comments'];
				$timestamp = $r['timestamp'];
				echo "
				<td width='30%' nowrap><span style='font-size:9pt;'><font face='Arial' color='#34A3D1'><a href='$url' target='_blank' ><b>$title</b></a></span></font></td>
				<td width='50%'   wrap><font size = '2' face='Arial' color='#666666'  >$comments</font></td>
				<td width='15%' nowrap><font size = '1' face='Arial' color='#666666'  >$timestamp</font></td>
                <td width='3%' align='center'><font size = '1' face='Arial' color='#666666' ><a href='$thisfile?edit&id=$id&page=$p'><b>.</b></a></font></td>
                <td width='3%' align='center'><font size = '1' face='Arial' color='#666666' ><a href='$thisfile?del&id=$id&page=$p'><b>.</b></a></font></td>

				<tr>
				";
			$i++;	
			}
			echo "</tr></table>";
				if (!isset($_POST['boton_search'])) {	
				  $callfunction = pagination($totalpages, $p, $i,$xorder,$xsort);
				}
}





#---------------------------------------------------------------------------------------------------------------------#
function pagination($totalpages, $p, $i,$xorder,$xsort) {
    global $connectt;
	if($p != 1)	{$pant = $p-1; echo "<span style='font-size:9pt;'><font face='Arial' color='#999999'><a href='$thisfile?p=$pant&xorder=$xorder&xsort=$xsort'><b>Previous</b></a>&nbsp;</span></font>";}
	for($i = 1; $i <= $totalpages; $i++){  
		if($p == $i){
		   echo "<span style='font-size:12pt;'><font face='Arial' color='#00000'><b>$i</b>&nbsp;</span></font>";
		}else{
		   echo "<span style='font-size:9pt;'><font face='Arial' color='#34A3D1'><a href='$thisfile?p=$i&xorder=$xorder&xsort=$xsort'><b>$i</b></a>&nbsp;</span></font>";
		}
    }
	if($p != $totalpages){$pant = $p+1; echo "<span style='font-size:9pt;'><font face='Arial' color='#000000'><a href='$thisfile?p=$pant&xorder=$xorder&xsort=$xsort'><b>Next</b></a>&nbsp;</span></font>";}
}

#---------------------------------------------------------------------------------------------------------------------#

?>