<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>Upload</title>
</head>
 <?php 
 //This is the directory where images will be saved 
 $target = "upload/"; 
 $target = $target . basename( $_FILES['Photo']['name']); 
 
 //This gets all the other information from the form 
 $tablep=$_POST['tablepic']; //table
 $fieldp=$_POST['fieldpic']; //field
/* $photop=$_POST['photopic'];*/
 $name=$_POST['name']; 
 $pic=($_FILES['Photo']['name']); 
 
 mysql_connect("localhost", "root", "root") or die(mysql_error()) ; 
 mysql_select_db("Leadbook") or die(mysql_error()) ; 
 mysql_query("UPDATE $tablep SET Photo='$pic' WHERE $fieldp='$name'");
 
 //Writes the photo to the server 
if (file_exists("upload/" . $_FILES["Photo"]["name"])) {
       echo $_FILES['Photo']['name'] . " already exists. "; }
    else { 
	   if(move_uploaded_file($_FILES['Photo']['tmp_name'], $target)) { 
             if ($_POST['tablepic'] == "Customer")  { 
             header('Location: CustEdit.php?CustNo=' . $name); } 
             else {
             header('Location: LeadEdit.php?LeadNo=' . $name); }
             exit(); } 
else { echo "Sorry, there was a problem uploading your file."; } 
}
 ?> 
<body>

</body>
</html>