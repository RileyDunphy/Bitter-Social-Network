<?php

include_once "connect.php";

class User {

    private $userId;
    private $userName;
    private $password;
    private $firstName;
    private $lastName;
    private $address;
    private $province;
    private $postalCode;
    private $contactNo;
    private $email;
    private $dateAdded;
    private $profImage;
    private $location;
    private $description;
    private $url;

    /* public function __construct($userId, $userName, $password, $firstName, $lastName, $address, $province, $postalCode, $contactNo, $email, $dateAdded, $profImage, $location, $description, $url) {
      $this->userId = $userId;
      $this->userName = $userName;
      $this->password = $password;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->address = $address;
      $this->province = $province;
      $this->postalCode = $postalCode;
      $this->contactNo = $contactNo;
      $this->email = $email;
      $this->dateAdded = $dateAdded;
      $this->profImage = $profImage;
      $this->location = $location;
      $this->description = $description;
      $this->url = $url;
      } */

    public function __destruct() {
        
    }

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

    public function insert() {
        global $con;

        $sql = "SELECT screen_name FROM users WHERE screen_name = '$this->userName'";
        $result = mysqli_query($con, $sql);
        if ($row = mysqli_fetch_array($result)) {
            return "Username already taken";
        } else {
            $sql = "INSERT INTO users
                (`first_name`,
                `last_name`,
                `screen_name`,
                `password`,
                `address`,
                `province`,
                `postal_code`,
                `contact_number`,
                `email`,
                `url`,
                `description`,
                `location`)
                VALUES ('$this->firstName', '$this->lastName', '$this->userName', '$this->password', '$this->address', '$this->province', '$this->postalCode', '$this->contactNo', '$this->email', '$this->url', '$this->description', '$this->location')";

            mysqli_query($con, $sql);
            //Check if the account has been properly inserted
            if (mysqli_affected_rows($con) == 1) {
                return "Account has been created";
            } else {
                return "Error creating account";
            }//end if(if inserted)
        }//end of big if(if screenname exists)
    }

    public function login() {
        global $con;
        $sql = "SELECT password from users where screen_name = '$this->userName'";
        $result = mysqli_query($con, $sql);
        if ($row = mysqli_fetch_array($result)) {
            $myHashedPassword = $row["password"];
            if (password_verify($this->password, $myHashedPassword)) {
                $sql = "SELECT * from users where screen_name = '$this->userName' AND BINARY password = '$myHashedPassword'";
                $result = mysqli_query($con, $sql);
                if ($row = mysqli_fetch_array($result)) {
                    session_start();
                    $_SESSION["SESS_FIRST_NAME"] = $row["first_name"];
                    $_SESSION["SESS_LAST_NAME"] = $row["last_name"];
                    $_SESSION["SESS_MEMBER_ID"] = $row["user_id"];
                    header("location:index.php?");
                } else {
                    $msg = "Error finding your account info";
                    header("location:login.php?message=$msg");
                }
            } else {
                $msg = "Error with your password";
                header("location:login.php?message=$msg");
            }
        } else {
            $msg = "Error with your username";
            header("location:login.php?message=$msg");
        }
    }

    public function editPhoto() {
        global $con;
        $sql = "UPDATE USERS SET profile_pic = '$this->profImage' WHERE user_id = " . $_SESSION["SESS_MEMBER_ID"];
        mysqli_query($con, $sql);
        if (mysqli_affected_rows($con) == 1) {
            return "Profile pic has been updated";
        } else {
            return "Error updating profile pic";
        }
    }

    public function getUsersToFollow() {
        global $con;
        //get users that are not you, and that you have not already followed
        $sql = "SELECT * from users where user_id != " . $_SESSION["SESS_MEMBER_ID"] . " "
                . "AND user_id NOT IN(SELECT to_id FROM FOLLOWS WHERE from_id = " . $_SESSION["SESS_MEMBER_ID"] . ")"
                . " ORDER BY RAND() LIMIT 3";
        //echo $sql;
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                $this->getUserById($row["user_id"]);
                $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                $outputString = substr($outputString, 0, 25);
                if ($row["profile_pic"] != "") {
                    echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                    . "<img class=\"bannericons\" src=\"images/profilepics/" . $row["user_id"] . "/" . $row["profile_pic"] . "\"> $outputString </a>";
                } else {
                    echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                    . "<img class=\"bannericons\" src=\"images/profilepics/default.jfif\"> $outputString </a>";
                }
                echo "<BR><a href=http://localhost/Follow_proc.php?user_id=" . $row["user_id"] . " style=\"background-color:black; color:yellow;\" class=\"btn\">Follow</a>";
                echo "<HR>";
            }
        }
    }

    public function getUserById($userId) {
        global $con;
        $sql = "SELECT * from users where user_id = " . $userId;
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        if ($row["first_name"] != "") {
            $this->userName = $row["screen_name"];
            $this->password = $row["password"];
            $this->firstName = $row["first_name"];
            $this->lastName = $row["last_name"];
            $this->address = $row["address"];
            $this->province = $row["province"];
            $this->postalCode = $row["postal_code"];
            $this->contactNo = $row["contact_number"];
            $this->email = $row["email"];
            $this->dateAdded = $row["date_created"];
            $this->profImage = $row["profile_pic"];
            $this->location = $row["location"];
            $this->description = $row["description"];
            $this->url = $row["url"];
        }
    }

    public function followUser($yourid, $theirid) {
        global $con;
        $sql = "SELECT * FROM FOLLOWS WHERE from_id = '$yourid' AND to_id = '$theirid'";
        mysqli_query($con, $sql);
        //if the query is successful then you are already following the user don't go into if
        if (mysqli_affected_rows($con) < 1) {
            $sql = "INSERT INTO follows
            (`from_id`,
            `to_id`)
            VALUES ('$yourid', '$theirid')";
            mysqli_query($con, $sql);
            if (mysqli_affected_rows($con) == 1) {
                return "Account has been followed";
            } else {
                return "Error following account";
            }//end if
        } else {
            return "Already following account";
        }
    }

    public function getUserStats($user_id) {
        global $con;
        $sql = "SELECT COUNT(user_id) FROM tweets WHERE user_id = $user_id";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $tweets = $row["COUNT(user_id)"];
        }
        $sql = "SELECT COUNT(from_id) FROM follows WHERE from_id = $user_id";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $following = $row["COUNT(from_id)"];
        }
        $sql = "SELECT COUNT(to_id) FROM follows WHERE to_id = $user_id";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $followers = $row["COUNT(to_id)"];
        }
        echo "<table>
          <tr><td>
            tweets</td><td>following</td><td>followers</td></tr>
          <tr><td>$tweets</td><td>$following</td><td>$followers</td>
         </tr></table>";
    }

    public function getFollowersYouKnow($user_id) {
        global $con;
        //get users that are not you, and that you have not already followed
        $sql = "SELECT * from users where user_id != " . $_SESSION["SESS_MEMBER_ID"] . " "
                . "AND user_id IN(SELECT to_id FROM FOLLOWS WHERE from_id = " . $_SESSION["SESS_MEMBER_ID"] . ") "
                . "AND user_id IN (SELECT to_id FROM FOLLOWS WHERE from_id = " . $user_id . ")"
                . " ORDER BY RAND() LIMIT 3";

        if ($result = mysqli_query($con, $sql)) {
            $numRows = mysqli_affected_rows($con);
            echo '<div class="bold">' . $numRows . ' &nbsp;Followers you know<BR>';
            while ($row = mysqli_fetch_array($result)) {
                $outputString = $row["first_name"] . " " . $row["last_name"] . " " . $row["screen_name"];
                $outputString = substr($outputString, 0, 25);
                if ($row["profile_pic"] != "") {
                    echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                    . "<img class=\"bannericons\" src=\"images/profilepics/" . $row["user_id"] . "/" . $row["profile_pic"] . "\"> $outputString </a>";
                } else {
                    echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                    . "<img class=\"bannericons\" src=\"images/profilepics/default.jfif\"> $outputString </a>";
                }
                echo "<HR>";
            }

            echo "</div>";
        }
    }

    public function getUsersSearch($search) {
        global $con;
        $sql = "select * from users where LOWER(screen_name) LIKE '%" . $search . "%' OR LOWER(first_name) LIKE '%" . $search . "%' OR LOWER(last_name) LIKE '%" . $search . "%'";
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                $outputString = substr($outputString, 0, 25);
                echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . "> $outputString </a>";
                $sql2 = "select * from follows where to_id = " . $row["user_id"] . " AND from_id = " . $_SESSION["SESS_MEMBER_ID"];
                $result2 = mysqli_query($con, $sql2);
                if (mysqli_num_rows($result2) > 0) {
                    echo "| Following";
                } else {
                    echo "<a href=http://localhost/Follow_proc.php?user_id=" . $row["user_id"] . " style=\"background-color:black; color:yellow;\" class=\"btn\">Follow</a>";
                }
                $sql2 = "select * from follows where from_id = " . $row["user_id"] . " AND to_id = " . $_SESSION["SESS_MEMBER_ID"];
                $result2 = mysqli_query($con, $sql2);
                if (mysqli_num_rows($result2) > 0) {
                    echo "| Follows You";
                }
                echo "<br><br>";
            }
        }
    }

    public function GetAllMessages() {
        global $con;
        $sql = "select * from messages INNER JOIN users on users.user_id = messages.from_id where messages.to_id = " . $_SESSION["SESS_MEMBER_ID"]." ORDER BY messages.date_sent DESC";
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                $outputString = substr($outputString, 0, 25);
                echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                . " $outputString </a>";
                //output the time
                date_default_timezone_set('America/Halifax');
                $postDate = new DateTime($row["date_sent"]);
                $today = new DateTime('now');
                $date = date_diff($postDate, $today);
                if (($date->y) > 0)
                    echo $date->format('%y year(s) ago');
                else if (($date->m) > 0)
                    echo $date->format('%m month(s) ago');
                else if (($date->d) > 1)
                    echo $date->format('%a days ago');
                else if (($date->d) == 1)
                    echo $date->format('%a day ago');
                else if (($date->h) > 1)
                    echo $date->format('%h hours ago');
                else if (($date->h) == 1)
                    echo $date->format('%h hour ago');
                else if (($date->i) > 1)
                    echo $date->format('%i minutes ago');
                else if (($date->i) == 1)
                    echo $date->format('%i minute ago');
                else
                    echo $date->format('%s seconds ago');
                //content of the tweet
                echo "<p>" . $row["message_text"] . "</p>";
                echo "<HR>";
            }
        }
    }

    public function AddMessage($message, $to) {
        $u = new User();
        $u->GetUserByScreenName($to);
        global $con;
        $sql = "insert into messages (from_id, to_id, message_text) values (" . $_SESSION["SESS_MEMBER_ID"] . ", $u->userId, '$message')";
        //echo $sql;
        mysqli_query($con, $sql);
        if (mysqli_affected_rows($con) > 0) {
            return "Message has been sent";
        } else {
            return "Error sending message";
        }
    }

    public function GetUserByScreenName($screen_name) {
        global $con;
        $sql = "select * from users where screen_name = '$screen_name'";
        //echo $sql;
        if ($result = mysqli_query($con, $sql)) {
            $row = mysqli_fetch_array($result);
            if ($row["first_name"] != "") {
                $this->userId = $row["user_id"];
                $this->userName = $row["screen_name"];
                $this->password = $row["password"];
                $this->firstName = $row["first_name"];
                $this->lastName = $row["last_name"];
                $this->address = $row["address"];
                $this->province = $row["province"];
                $this->postalCode = $row["postal_code"];
                $this->contactNo = $row["contact_number"];
                $this->email = $row["email"];
                $this->dateAdded = $row["date_created"];
                $this->profImage = $row["profile_pic"];
                $this->location = $row["location"];
                $this->description = $row["description"];
                $this->url = $row["url"];
            }
        }
    }

    public function GetUsers($input) {
        global $con;
        $users = array();
        $input = strtolower($input);
        $sql = "select * from users INNER JOIN follows on follows.to_id = users.user_id where LOWER(users.screen_name) LIKE '%$input%' AND follows.from_id = " . $_SESSION["SESS_MEMBER_ID"];
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {
            array_push($users, $row["screen_name"]);
        }
        return $users;
    }

}
