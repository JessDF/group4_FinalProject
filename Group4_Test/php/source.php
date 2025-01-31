<?php

//include 'inc/dbConnection.php';

//$dbConn = getDBConnection();

/*
*Form vars - All input converted to lower case.
*/
// $title= strtolower( $_POST['title']);// User input deviceName
// $creator= strtolower( $_POST['creator']);// User input deviceName
// $pub= strtolower( $_POST['publisher']);// User selected deviceType
// $year = $_POST['year'];// Selection display type
// $issue = $_POST['issue'];//User input item statusable selection
// $sortBy = $_POST['sortBy'];

//$creator, $sortBy - from above

// $city = strtolower( $_POST['city']);
// $conName= strtolower( $_POST['conName']);
// $state= strtoupper( $_POST['state']);
// $turnOut=  $_POST['turnOut'];
// $website= $_POST['website'];


/*
*@input: sql string to be processed
*@output: table from the sql query
*/
function preExeFet($sql){
    global $dbConn, $nPara;
    
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute($nPara);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $records;
}
function preExeFetNOPARA($sql){
    global $dbConn;
    
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $records;
}

/*
*@input: 
*@output: all contents of device table for the user in alphebetical order
*/
function getInfo( $table ) {
    $sql = "SELECT * FROM ".$table;
    return preExeFetNOPARA($sql);
}

/*
*@input: form input by user: partial device name, dropdown device type, order by price or name and statusablity
*@output: returns a table based on the query including a device count. a-e letters allow for different output order.
*/    
// function goSQLcomic($table){
//     global $title, $creator, $pub, $year, $issue, $sortBy, $nPara;
//     $needle = "WHERE";//If the 'where' keyword is used  then 'and 'is added to the string in place of.
    
//     $sql = "SELECT title, creator, publisher, year, issue FROM ".$table;
    
//     if( $title ){
//         //Prevents SQL injection by using a named parameter.
//         $nPara[':dTitle'] = '%'.$title.'%';
//         $sql .= " WHERE title LIKE :dTitle ";

//     }
//     if( $creator ){
//         if (strlen(stristr($sql,$needle))>0) { //String search for 'where': stristr returns the partial string up to 'where'.
//         // Needle Found                     compare lenth>0 means the keyword was found.  http://www.maxi-pedia.com/string+contains+substring+php
//             $sql .= " AND ";
//         }else{
//             $sql .= " WHERE ";
//         }
//         //Prevents SQL injection by using a named parameter.
//         $nPara[':dCreator'] = '%'.$creator.'%';
//         $sql .= " creator LIKE :dCreator ";
        
//     }
//     if( $pub ){
//         if (strlen(stristr($sql,$needle))>0) { //String search for 'where': stristr returns the partial string up to 'where'.
//         // Needle Found                     compare lenth>0 means the keyword was found.  http://www.maxi-pedia.com/string+contains+substring+php
//             $sql .= " AND ";
//         }else{
//             $sql .= " WHERE ";
//         }
//         //Prevents SQL injection by using a named parameter.
//         $nPara[':dPub'] = '%'.$pub.'%';
//         $sql .= " publisher LIKE :dPub ";
        
//     }

//     if( isset($_POST['allIn']) ){ // Added due to user submitting a blank form.
//       $sql.= " ";
//     }
    
//     if( $sortBy ){ // Name or price
//         $sql .=" ORDER BY ".$sortBy ;
//     }
//     //echo $sql;
//     return preExeFet($sql);
// }

function get($table, $column){
    $sql = "SELECT DISTINCT ".$column." FROM ".$table;
    return preExeFetNOPARA($sql);
}

// function goSQLcon($table){
//     global $city, $creator, $conName, $state, $turnOut, $website, $sortBy, $nPara;
//     $needle = "WHERE";//If the 'where' keyword is used  then 'and 'is added to the string in place of.
    
//     $sql = "SELECT conName, city, state, turnOut, creator, website FROM ".$table;
    
//     if( $conName ){
//         //Prevents SQL injection by using a named parameter.
//         $nPara[':dConName'] = '%'.$conName.'%';
//         $sql .= " WHERE conName LIKE :dConName ";

//     }
//     if( $creator ){
//         if (strlen(stristr($sql,$needle))>0) { //String search for 'where': stristr returns the partial string up to 'where'.
//         // Needle Found                     compare lenth>0 means the keyword was found.  http://www.maxi-pedia.com/string+contains+substring+php
//             $sql .= " AND ";
//         }else{
//             $sql .= " WHERE ";
//         }
//         //Prevents SQL injection by using a named parameter.
//         $nPara[':dCreator'] = '%'.$creator.'%';
//         $sql .= " creator LIKE :dCreator ";
        
//     }
//     if( $state ){
//         if (strlen(stristr($sql,$needle))>0) { //String search for 'where': stristr returns the partial string up to 'where'.
//         // Needle Found                     compare lenth>0 means the keyword was found.  http://www.maxi-pedia.com/string+contains+substring+php
//             $sql .= " AND ";
//         }else{
//             $sql .= " WHERE ";
//         }
//         //Prevents SQL injection by using a named parameter.
//         $nPara[':dState'] = '%'.$state.'%';
//         $sql .= " state LIKE :dState ";
        
//     }

//     if( isset($_POST['allIn']) ){ // Added due to user submitting a blank form.
//       $sql.= " ";
//     }
    
//     if( $sortBy ){ // Name or price
//         $sql .=" ORDER BY ".$sortBy ;
//     }
//     //echo $sql;
//     return preExeFet($sql);
// }

//login.php
/*
*@input: login process accesssed by login.php with user input
*@output: successful login  directs user to index.php
*/
function goMain(){
    global $dbConn;
    
    $userForm = $_POST['username'];
    //$pwForm = sha1($_POST['password']);   //hash("sha1",$_POST['password']);    //  !!!!!!!  must have some type of encryption for the PW  !!!!!!!!!!!!!!!!!!
    $pwForm = $_POST['password'];
    
    //USE NAMEDPARAMETERS TO PREVENT SQL INJECTION
    $sql = "SELECT * FROM admin WHERE username = :username AND password = :password";
    
    $nPara[':username'] = $userForm;
    $nPara[':password'] = $pwForm;
    
    $statement = $dbConn->prepare($sql);
    $statement->execute($nPara);
    $record = $statement->fetch(PDO::FETCH_ASSOC);

     if (empty($record)) { //wrong credentials
       echo"<form method='POST' action='index.php'>";
            echo"<span style='color:red'><h5>Wrong username or password.</h5></span>";
       echo"</form>";
     } else {
         $_SESSION["name"] = $record['name'];
         //$_SESSION["email"] = $record['email'];
         //$_SESSION["user"]  = $record['username'];
         $_SESSION["user"] = "active";
         echo "Welcome ". $_SESSION["user"]."<br>";
         header("Location: index.php"); //redirect to some page
     }
}

//https://stackoverflow.com/questions/13851528/how-to-pop-an-alert-message-box-using-php
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}


//admin.php
/*
function info(){
    //global $userData;
    //http://php.net/manual/en/function.explode.php
    //$data = $_GET['$userData'];
    $pie = explode(",", $_GET['con_Id']);
    foreach($pie as $slice){
        echo"<br>".$slice;
    }
}

<div id="iframecss">
            <iframe src="" width="300" height="300" name="userInfoFrame"></iframe>
        </div>        
*/

//conInsert.php and conUpdate.php
// function getConInfo($con_id){
//     global $dbConn;
//     $sql = "SELECT * FROM convention WHERE con_id = $con_id"; 
//     $stmt = $dbConn -> prepare ($sql);
//     $stmt -> execute();
//     $record = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $record;
// }

//conInsert.php
// function addCon(){
//     global $dbConn;
// if(isset($_GET['submit'])) {  //admin has submitted the "update user" form
//           $sql = "INSERT INTO convention (
//                     con_id,  
//                     conName,   
//                     city,   
//                     state,  
//                     creator,  
//                     website,  
//                     turnOut   
//                 )
//                 VALUES (
//                 :con_id,:conName,:city, :state, :creator, :website,:turnOut
//                 )";
                  
//           $nPara = array();        
//           $nPara[':con_id'] = $_GET['con_id'];       
//           $nPara[':conName']  = $_GET['conName'];
//           $nPara[':city'] = $_GET['city'];
//           $nPara[':state'] = $_GET['state'];
//           $nPara[':creator'] = $_GET['creator'];
//           $nPara[':website'] = $_GET['website'];
//           $nPara[':turnOut'] = $_GET['turnOut'];
          
//           $stmt = $dbConn->prepare($sql);
//           $stmt->execute($nPara);
//           //clear the value - prevent multiple insertions
//           $nPara = array();  
//         }//eof if
// }

?>
