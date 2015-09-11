<?php
$con = pg_connect("host=stevie.heliohost.org dbname=agupta80_musicdb user=agupta80_ashu	password=musicdb")
    or die('Could not connect: ' . pg_last_error());
$title=pg_escape_string($_POST[title]);
$artist=pg_escape_string($_POST[artist]);
$sql="SELECT * FROM song WHERE LOWER(title)=LOWER('$title')";
$result = pg_query($con, $sql) or die("Cannot execute query: $sql\n");
$count=pg_num_rows($result);
$flag=0;
if($count==0){
$sql="INSERT INTO song(title) Values ('$title')";
$result = pg_query($con, $sql) or die("Cannot execute query: $sql\n");
$sql="SELECT * FROM song WHERE LOWER(title)=LOWER('$title')";
$result = pg_query($con, $sql) or die("Cannot execute query: $sql\n");
$row = pg_fetch_assoc($result);
$ids=$row['id'];
}
else
{
 $row = pg_fetch_assoc($result);
 $ids=$row['id'];
 $flag=$flag+1;
}
$sql="SELECT * FROM artist_group WHERE LOWER(name)=LOWER('$artist')";
$result = pg_query($con, $sql) or die("Cannot execute query: $sql\n");
$count=pg_num_rows($result);
if($count==0){
$sql="INSERT INTO artist_group(name) Values ('$artist')";
$result = pg_query($con, $sql) or die("Cannot execute query: $sql\n");
$sql="SELECT * FROM artist_group WHERE LOWER(name)=LOWER('$artist')";
$result = pg_query($con, $sql) or die("Cannot execute query: $sql\n");
$row = pg_fetch_assoc($result);
$ida=$row['id'];
}
else
{
  $flag=$flag+1;
 $row = pg_fetch_assoc($result);
 $ida=$row['id'];
}
if($flag!=2)
{
$sql="INSERT INTO By  Values ('$ids','$ida')";
$result = pg_query($con, $sql) or die("Cannot execute query: $sql\n");
}
header("location:insert.html");
?>