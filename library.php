<?php

function checkConnection(){
    define('LOCALHOST','localhost');
    define('USERNAME','root');
    define('PASS','');
    define('DB','practice_project');
    
    try {
        $pdo = new PDO("mysql:host=".LOCALHOST.";dbname=".DB, USERNAME, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Perform database operations here
        
        return $pdo; // Return the PDO Object
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// $pdo = checkConnection();

// $sql = 'SELECT * 
// 		FROM wp_users';

// $statement = $pdo->query($sql);

// // get all users
// $users = $statement->fetchAll(PDO::FETCH_ASSOC);

// if ($users) {
// 	// show the publishers
// 	foreach ($users as $user) {
// 		echo $user['user_login'] . '<br>';
// 		echo $user['user_pass'] . '<br>';
// 		echo $user['user_nicename'] . '<br>';
// 		echo $user['user_email'] . '<br>';
// 	}
// }
// add_action("init","checkConnection");
// print_r(checkConnection());


function insertintoTable(){
    
}





