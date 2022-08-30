<?php

require_once 'user.php';
require_once 'ConnectionManager.php';

class userDAO {

    public function getUser() {


    // STEP 1 - connect to sql 
    $connMgr = new ConnectionManager(); //connectionmanager object
    $pdo = $connMgr->connect(); // PDO object

    $sql = "SELECT 
                username, email, password, searchHistory,favourite
            FROM
                project";
    $stmt = $pdo->prepare($sql); // PDOStatement object
    $stmt->execute(); // RUN SQL

    $stmt->setFetchMode(PDO::FETCH_ASSOC); // Associative Array
    
    $users = []; // Array of Cat objects, empty now
        while ( $row = $stmt->fetch() ) {
            $user = new User( 
                        $row['username'], 
                        $row['email'], 
                        $row['password'], 
                        $row['searchHistory'],
                        $row['favourite']
                    ); // new Cat object
            $users[] = $user; // add Cat object to ret array
        }
        $stmt = null; // clear memory
        $pdo = null; // clear memory
        
        // STEP 6
        return $users;
    } 

    
    public function getUsersbyUsername($username) {
            // STEP 1
            $connMgr = new ConnectionManager();
            $pdo = $connMgr->connect(); // PDO object
    
            // STEP 2
            $sql = "SELECT
                        username, email, password, searchHistory,favourite
                    FROM
                        project
                    WHERE
                        username = :username ";
            // :status --> 'placeholder'
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            
            // STEP 3
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
           
            // STEP 4
            $users = [];
            while ($row = $stmt->fetch() ) {
                $user = new User( 
                        $row['username'], 
                        $row['email'], 
                        $row['password'], 
                        $row['searchHistory'],
                        $row['favourite']
                    );
                $users[] = $user;
            }
           
            // STEP 5
            $stmt = null;
            $pdo = null;        
            
            // STEP 6
            return $users;

        }


    public function newSignUp($username, $email, $password) {        
        // For new cats, default is 'A' (available)
        

        // STEP 1
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->connect(); // PDO object
        
        $searchHistory = "";
        $favourite = "";

        // STEP 2
        $sql = "INSERT INTO project
                    ( username, email, password, searchHistory, favourite)
                VALUES
                    ( :username, :email, :password, :searchHistory, :favourite )";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':searchHistory', $searchHistory, PDO::PARAM_STR);
        $stmt->bindParam(':favourite', $favourite, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        
        
        // STEP 3
        $isOk = $stmt->execute();
        
        // STEP 4
        $stmt = null;
        $pdo = null;        
        
        // STEP 5
        return $isOk;
    }


    public function login($username) {

        // Step 1 - Connect to Database
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->connect();

        // Step 2 - Prepare SQL
        $sql = "SELECT
                password
            FROM
                project
            WHERE
                username = :username
                ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        // $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        
        // Step 3 - Execute SQL
        $result = $stmt->execute();

    
        $password = null;
        if( $stmt->execute() ) {

            // Step 4 - Retrieve Query Results
            if( $row = $stmt->fetch() ) {
                $password = $row['password'];
            }
        }
        
        // Step 5 - Clear Resources
        $stmt = null;
        $pdo = null;

        // Step 6 - Return
        return $password;
    }


    public function getHashedPassword($username) {

        // Step 1 - Connect to Database
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection();

        // Step 2 - Prepare SQL
        $sql = "SELECT
                    hashed_password
                FROM
                    account
                WHERE
                    username = :username
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        // Step 3 - Execute SQL
        $hashed_password = null;
        
        if( $stmt->execute() ) {

            // Step 4 - Retrieve Query Results
            if( $row = $stmt->fetch() ) {
                $hashed_password = $row['hashed_password'];
            }
        }
        
        // Step 5 - Clear Resources
        $stmt = null;
        $pdo = null;

        // Step 6 - Return
        return $hashed_password;
    }

    public function resetPassword($username, $password) {
        $connMgr = new ConnectionManager();
        $pdo = $connMgr->getConnection();

        
    }

    public function searchHistoryChange($username, $searchHistory){
         // Step 1 - Connect to Database
         $connMgr = new ConnectionManager();
         $pdo = $connMgr->connect();
 
         // Step 2 - Prepare SQL
         

         $sql = "UPDATE project

                 SET
                    searchHistory = :searchHistory
                 WHERE 
                    username = :username
                 ";
         $stmt = $pdo->prepare($sql);
         $stmt->bindParam(':username', $username, PDO::PARAM_STR);
         $stmt->bindParam(':searchHistory', $searchHistory, PDO::PARAM_STR);
         // $stmt->bindParam(':password', $password, PDO::PARAM_STR);
         
         // Step 3 - Execute SQL
         $result = $stmt->execute();
         // Step 5 - Clear Resources
         $stmt = null;
         $pdo = null;
 
         // Step 6 - Return
         return $result;
         
    }

    public function favouriteChange($username , $favourite){
        $connMgr = new ConnectionManager();
         $pdo = $connMgr->connect();
 
         // Step 2 - Prepare SQL
         

         $sql = "UPDATE project

                 SET
                 favourite = :favourite
                 WHERE 
                    username = :username
                 ";
         $stmt = $pdo->prepare($sql);
         $stmt->bindParam(':username', $username, PDO::PARAM_STR);
         $stmt->bindParam(':favourite', $favourite, PDO::PARAM_STR);
         // $stmt->bindParam(':password', $password, PDO::PARAM_STR);
         
         // Step 3 - Execute SQL
         $result = $stmt->execute();
         // Step 5 - Clear Resources
         $stmt = null;
         $pdo = null;

         return $result;

    }
}