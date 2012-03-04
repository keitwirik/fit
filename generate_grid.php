<?php 

//FIXME this has to go up here because something in dbo.php is outputting a line break, which is bad

$s = '';
// we should set the appropriate header information. Do not forget this.
header("Content-type: text/xml;charset=utf-8");
 
echo "<?xml version='1.0' encoding='utf-8'?>";


//include the information needed for the connection to MySQL data base server. 
// we store here username, database and password 
include("dbo.php");
 
// to the url parameter are added 4 parameters as described in colModel
// we should get these parameters to construct the needed query
// Since we specify in the options of the grid that we will use a GET method 
// we should use the appropriate command to obtain the parameters. 
// In our case this is $_GET. If we specify that we want to use post 
// we should use $_POST. Maybe the better way is to use $_REQUEST, which
// contain both the GET and POST variables. For more information refer to php documentation.
// Get the requested page. By default grid sets this to 1. 
$page = $_GET['page']; 
 
// get how many rows we want to have into the grid - rowNum parameter in the grid 
$limit = $_GET['rows']; 
 
// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel 
$sidx = $_GET['sidx']; 
 
// sorting order - at first time sortorder 
$sord = $_GET['sord']; 
 
// if we not pass at first time index use the first column for the index or what you want
if(!$sidx) $sidx =1; 
 
// calculate the number of rows for the query. We need this for paging the result 

# using the shortcut ->query() method here since there are no variable  
# values in the select statement.  
$STH = $DBH->query('SELECT COUNT(*) AS count from records');  
  
# setting the fetch mode  
$STH->setFetchMode(PDO::FETCH_ASSOC); 

//$count = $row['count']; 
$count = $STH->fetch(); 
$count = $count['count'];
// calculate the total pages for the query 
if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
} else { 
              $total_pages = 0; 
} 
 
// if for some reasons the requested page is greater than the total 
// set the requested page to body_fat page 
if ($page > $total_pages) $page=$total_pages;
 
// calculate the starting position of the rows 
$start = $limit*$page - $limit;
 
// if for some reasons start position is negative set it to 0 
// typical case is that the user type 0 for the requested page 
if($start <0) $start = 0; 
 
// the actual query for the grid data 

$STH = $DBH->query("SELECT id, timestamp, weight, bmi, 
                    body_fat, muscle, body_age, visceral_fat,
                    rm, waist FROM records 
                    ORDER BY $sidx $sord LIMIT $start , $limit");

# setting the fetch mode  
$STH->setFetchMode(PDO::FETCH_ASSOC); 

//$SQL = "SELECT id, timestamp, weight, bmi, body_fat, muscle, body_age,
//         visceral_fat, rm, waist FROM records 
//        ORDER BY $sidx $sord LIMIT $start , $limit"; 
//$result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()); 
 
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
// be sure to put text data in CDATA
while($row = $STH->fetch()) {
    $s .= "<row id='". $row['id']."'>";            
    // $s .= "<cell>". $row['id']."</cell>";
    $s .= "<cell>". $row['timestamp']."</cell>";
    $s .= "<cell>". $row['weight']."</cell>";
    $s .= "<cell>". $row['bmi']."</cell>";
    $s .= "<cell>". $row['body_fat']."</cell>";
    $s .= "<cell>". $row['muscle']."</cell>";
    $s .= "<cell>". $row['body_age']."</cell>";
    $s .= "<cell>". $row['visceral_fat']."</cell>";
    $s .= "<cell>". $row['waist']."</cell>";
    $s .= "<cell>". $row['rm']."</cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>
