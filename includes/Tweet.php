<?php

class Tweet {

    private $tweetId;
    private $originalTweetId;
    private $tweetText;
    private $replytoTweetId;
    private $userId;
    private $dateAdded;

    public function __destruct() {
        
    }

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }

    public function reply($tweet, $tweetid) {
        global $con;
        $sql = "INSERT INTO tweets
            (tweet_text, user_id, original_tweet_id, reply_to_tweet_id, date_created)
            VALUES ('$tweet', " . $_SESSION['SESS_MEMBER_ID'] . ", 0, $tweetid, NOW())";
        //echo $sql;
        mysqli_query($con, $sql);
        //Check if the tweet has been properly inserted
        if (mysqli_affected_rows($con) == 1) {
            return $this->getReplyAJAX(mysqli_insert_id($con));
            //return 'Reply has been posted';
        } else {
            return "Error posting reply";
        }//end if(if inserted)
    }

    public function getReplyAJAX($tweetid) {
        global $con;
        $sql = "SELECT *, DATE_FORMAT(tweets.date_created, '%m/%d/%y %T') AS date from tweets INNER JOIN users on users.user_id = tweets.user_id where tweet_id = $tweetid";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {

            $reply = '<div style="border: 3px solid black;"><img class="smallicon" src="images/Reply-1.png"><br>';
            $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
            $outputString = substr($outputString, 0, 25);
            $reply .= "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                    . " $outputString </a>";
            //output the time
            date_default_timezone_set('America/Halifax');
            $postDate = new DateTime($row["date"]);
            $today = new DateTime('now');
            $date = date_diff($postDate, $today);
            if (($date->y) > 0)
                $reply .= $date->format('%y year(s) ago');
            else if (($date->m) > 0)
                $reply .= $date->format('%m month(s) ago');
            else if (($date->d) > 1)
                $reply .= $date->format('%a days ago');
            else if (($date->d) == 1)
                $reply .= $date->format('%a day ago');
            else if (($date->h) > 1)
                $reply .= $date->format('%h hours ago');
            else if (($date->h) == 1)
                $reply .= $date->format('%h hour ago');
            else if (($date->i) > 1)
                $reply .= $date->format('%i minutes ago');
            else if (($date->i) == 1)
                $reply .= $date->format('%i minute ago');
            else
                $reply .= $date->format('%s seconds ago');
            //content of the tweet
            $reply .= "<p>" . $row["tweet_text"] . "</p>";
            //buttons
            if ($this->CheckLiked($row["tweet_id"], $_SESSION["SESS_MEMBER_ID"])) {
                $reply .= "<img class=\"smallicon\" src=\"images/liked.png\">";
            } else {
                $reply .= "<a href=\"liketweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/like.ico\"></a>";
            }
            $reply .= "<a href=\"retweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/retweet.png\"></a>";
            $reply .= "</div>";
            return $reply;
        }
    }

    public function insert($tweet) {
        global $con;
        $sql = "INSERT INTO tweets
            (tweet_text, user_id, original_tweet_id, reply_to_tweet_id, date_created)
            VALUES ('$tweet', " . $_SESSION['SESS_MEMBER_ID'] . ", 0, 0, NOW())";
        mysqli_query($con, $sql);
        //Check if the tweet has been properly inserted
        if (mysqli_affected_rows($con) == 1) {
            return "Tweet has been posted";
        } else {
            return "Error posting tweet";
        }//end if(if inserted)
    }

    public function insertRetweet($tweet_id) {
        global $con;
        $sql = "SELECT * FROM TWEETS WHERE tweet_id = $tweet_id";
        $result = mysqli_query($con, $sql);
        if ($row = mysqli_fetch_array($result)) {
            if ($row["original_tweet_id"] == 0) {
                //if the original tweet id is the zero thats the original tweet so pass its tweet id in
                $sql = "INSERT INTO tweets
                    (tweet_text, user_id, original_tweet_id, reply_to_tweet_id, date_created)
                    VALUES ('" . $row["tweet_text"] . "', " . $_SESSION['SESS_MEMBER_ID'] . ", " . $row["tweet_id"] . ", 0, NOW())";
            } else {
                //if the original tweet id is already set, you must be retweeting a retweet
                //pass in the original tweet id so the original authors name will keep being shown
                $sql = "INSERT INTO tweets
                    (tweet_text, user_id, original_tweet_id, reply_to_tweet_id, date_created)
                    VALUES ('" . $row["tweet_text"] . "', " . $_SESSION['SESS_MEMBER_ID'] . ", " . $row["original_tweet_id"] . ", 0, NOW())";
            }
            mysqli_query($con, $sql);
            //Check if the tweet has been properly inserted
            if (mysqli_affected_rows($con) == 1) {
                return "Tweet has been retweeted";
            } else {
                return "Error retweeting";
            }//end if(if inserted)
        } else {
            return "Error finding tweet in database";
        }
    }

    public function likeTweet($tweet_id) {
        global $con;
        $sql = "select * from likes where tweet_id = " . $tweet_id . " AND user_id = " . $_SESSION['SESS_MEMBER_ID'];
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        if ($row != null) {
            return "Tweet has already been liked";
        } else {
            $sql = "insert into likes (tweet_id, user_id) values (" . $tweet_id . ", " . $_SESSION['SESS_MEMBER_ID'] . ")";
            mysqli_query($con, $sql);
            if (mysqli_affected_rows($con) == 1) {
                return "Tweet has been liked";
            } else {
                return "Error like tweet";
            }//end if(if inserted)
        }
    }

    public function getReplys($tweetid) {
        global $con;
        $sql = "SELECT *, DATE_FORMAT(tweets.date_created, '%m/%d/%y %T') AS date from tweets INNER JOIN users on users.user_id = tweets.user_id where reply_to_tweet_id = $tweetid 
                ORDER BY tweets.date_created DESC LIMIT 10";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($result)) {

            echo '<div style="border: 3px solid black;"><img class="smallicon" src="images/Reply-1.png"><br>';
            $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
            $outputString = substr($outputString, 0, 25);
            echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
            . " $outputString </a>";
            //output the time
            date_default_timezone_set('America/Halifax');
            $postDate = new DateTime($row["date"]);
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
            echo "<p>" . $row["tweet_text"] . "</p>";
            //buttons
            if ($this->CheckLiked($row["tweet_id"], $_SESSION["SESS_MEMBER_ID"])) {
                echo "<img class=\"smallicon\" src=\"images/liked.png\">";
            } else {
                echo "<a href=\"liketweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/like.ico\"></a>";
            }
            echo "<a href=\"retweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/retweet.png\"></a>";
            echo "</div>";
        }
    }

    public function getTweets() {
        global $con;
        //get tweets that are yours, or that you have followed
        $sql = "SELECT *, DATE_FORMAT(tweets.date_created, '%m/%d/%y %T') AS date from tweets INNER JOIN users on users.user_id = tweets.user_id where reply_to_tweet_id = 0 and tweets.user_id = " . $_SESSION["SESS_MEMBER_ID"] . " "
                . "OR tweets.user_id IN(SELECT to_id FROM FOLLOWS WHERE from_id = " . $_SESSION["SESS_MEMBER_ID"] . ")"
                . " ORDER BY tweets.date_created DESC LIMIT 10";
        //echo $sql;
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                //output the name
                //echo $row["original_tweet_id"];
                if ($row["original_tweet_id"] == 0 && $row["reply_to_tweet_id"] == 0) {
                    $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                    $outputString = substr($outputString, 0, 25);
                    echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                    . " $outputString </a>";
                    //output the time
                    date_default_timezone_set('America/Halifax');
                    $postDate = new DateTime($row["date"]);
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
                    echo "<p>" . $row["tweet_text"] . "</p>";
                    //buttons
                    if ($this->CheckLiked($row["tweet_id"], $_SESSION["SESS_MEMBER_ID"])) {
                        echo "<img class=\"smallicon\" src=\"images/liked.png\">";
                    } else {
                        echo "<a href=\"liketweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/like.ico\"></a>";
                    }
                    echo "<a href=\"retweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/retweet.png\"></a>";
                    echo '<p id="submit_comment_link"><a href="#" data-id="' . $row["tweet_id"] . '" >Submit a comment!</a></p>';
                    $this->getReplys($row["tweet_id"]);
                    echo "<HR>";
                } else if ($row["original_tweet_id"] != 0 && $row["reply_to_tweet_id"] == 0) {
                    $sql2 = "SELECT users.user_id, users.first_name, users.last_name, users.screen_name FROM USERS INNER JOIN TWEETS ON users.user_id = tweets.user_id WHERE tweets.tweet_id = " . $row["original_tweet_id"];
                    $result2 = mysqli_query($con, $sql2);
                    if ($row2 = mysqli_fetch_array($result2)) {
                        $outputString = $row2["first_name"] . " " . $row2["last_name"] . " @" . $row2["screen_name"];
                        $outputString = substr($outputString, 0, 25);
                        echo "<a href=http://localhost/userpage.php?user_id=" . $row2["user_id"] . ">"
                        . " $outputString </a>";
                        //output the time
                        date_default_timezone_set('America/Halifax');
                        $postDate = new DateTime($row["date"]);
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
                        echo " <b>retweeted from " . $row["first_name"] . " " . $row["last_name"] . "</b>";
                        //content of the tweet
                        echo "<p>" . $row["tweet_text"] . "</p>";
                        //buttons
                        if ($this->CheckLiked($row["tweet_id"], $_SESSION["SESS_MEMBER_ID"])) {
                            echo "<img class=\"smallicon\" src=\"images/liked.png\">";
                        } else {
                            echo "<a href=\"liketweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/like.ico\"></a>";
                        }
                        echo "<a href=\"retweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/retweet.png\"></a>";
                        echo '<p id="submit_comment_link"><a href="#" data-id="' . $row["tweet_id"] . '" >Submit a comment!</a></p>';
                        $this->getReplys($row["tweet_id"]);
                        echo "<HR>";
                    }
                }
            }
        }
    }

    public function getTweetsForUser($user_id) {
        global $con;
        //get tweets that are yours, or that you have followed
        $sql = "SELECT *, DATE_FORMAT(tweets.date_created, '%m/%d/%y %T') AS date from tweets INNER JOIN users on users.user_id = tweets.user_id where reply_to_tweet_id = 0 and tweets.user_id = " . $user_id . " "
                . " ORDER BY tweets.date_created DESC LIMIT 10";
        //echo $sql;
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                //output the name
                //echo $row["original_tweet_id"];
                if ($row["original_tweet_id"] == 0 && $row["reply_to_tweet_id"] == 0) {
                    $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                    $outputString = substr($outputString, 0, 25);
                    echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                    . " $outputString </a>";
                    //output the time
                    date_default_timezone_set('America/Halifax');
                    $postDate = new DateTime($row["date"]);
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
                    echo "<p>" . $row["tweet_text"] . "</p>";
                    //buttons
                    if ($this->CheckLiked($row["tweet_id"], $_SESSION["SESS_MEMBER_ID"])) {
                        echo "<img class=\"smallicon\" src=\"images/liked.png\">";
                    } else {
                        echo "<a href=\"liketweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/like.ico\"></a>";
                    }
                    echo "<a href=\"retweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/retweet.png\"></a>";
                    echo '<p id="submit_comment_link"><a href="#" data-id="' . $row["tweet_id"] . '" >Submit a comment!</a></p>';
                    $this->getReplys($row["tweet_id"]);
                    echo "<HR>";
                } else if ($row["original_tweet_id"] != 0 && $row["reply_to_tweet_id"] == 0) {
                    $sql2 = "SELECT users.user_id, users.first_name, users.last_name, users.screen_name FROM USERS INNER JOIN TWEETS ON users.user_id = tweets.user_id WHERE tweets.tweet_id = " . $row["original_tweet_id"];
                    $result2 = mysqli_query($con, $sql2);
                    if ($row2 = mysqli_fetch_array($result2)) {
                        $outputString = $row2["first_name"] . " " . $row2["last_name"] . " @" . $row2["screen_name"];
                        $outputString = substr($outputString, 0, 25);
                        echo "<a href=http://localhost/userpage.php?user_id=" . $row2["user_id"] . ">"
                        . " $outputString </a>";
                        //output the time
                        date_default_timezone_set('America/Halifax');
                        $postDate = new DateTime($row["date"]);
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
                        echo " <b>retweeted from " . $row["first_name"] . " " . $row["last_name"] . "</b>";
                        //content of the tweet
                        echo "<p>" . $row["tweet_text"] . "</p>";
                        //buttons
                        if ($this->CheckLiked($row["tweet_id"], $_SESSION["SESS_MEMBER_ID"])) {
                            echo "<img class=\"smallicon\" src=\"images/liked.png\">";
                        } else {
                            echo "<a href=\"liketweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/like.ico\"></a>";
                        }
                        echo "<a href=\"retweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/retweet.png\"></a>";
                        echo '<p id="submit_comment_link"><a href="#" data-id="' . $row["tweet_id"] . '" >Submit a comment!</a></p>';
                        $this->getReplys($row["tweet_id"]);
                        echo "<HR>";
                    }
                }
            }
        }
    }

    public function getTweetsSearch($search) {
        global $con;
        $sql = "select *,DATE_FORMAT(tweets.date_created, '%m/%d/%y %T') AS date from tweets INNER JOIN users ON users.user_id = tweets.user_id where LOWER(tweets.tweet_text) LIKE '%" . $search . "%' ORDER BY tweets.date_created DESC";
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                if ($row["original_tweet_id"] == 0 && $row["reply_to_tweet_id"] == 0) {
                    $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                    $outputString = substr($outputString, 0, 25);
                    echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                    . " $outputString </a>";
                    //output the time
                    date_default_timezone_set('America/Halifax');
                    $postDate = new DateTime($row["date"]);
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
                    echo "<p>" . $row["tweet_text"] . "</p>";
                    //buttons
                    if ($this->CheckLiked($row["tweet_id"], $_SESSION["SESS_MEMBER_ID"])) {
                        echo "<img class=\"smallicon\" src=\"images/liked.png\">";
                    } else {
                        echo "<a href=\"liketweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/like.ico\"></a>";
                    }
                    echo "<a href=\"retweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/retweet.png\"></a>";
                    echo '<p id="submit_comment_link"><a href="#" data-id="' . $row["tweet_id"] . '" >Submit a comment!</a></p>';
                    $this->getReplys($row["tweet_id"]);
                    echo "<HR>";
                } else if ($row["original_tweet_id"] != 0 && $row["reply_to_tweet_id"] == 0) {
                    $sql2 = "SELECT users.user_id, users.first_name, users.last_name, users.screen_name FROM USERS INNER JOIN TWEETS ON users.user_id = tweets.user_id WHERE tweets.tweet_id = " . $row["original_tweet_id"];
                    $result2 = mysqli_query($con, $sql2);
                    if ($row2 = mysqli_fetch_array($result2)) {
                        $outputString = $row2["first_name"] . " " . $row2["last_name"] . " @" . $row2["screen_name"];
                        $outputString = substr($outputString, 0, 25);
                        echo "<a href=http://localhost/userpage.php?user_id=" . $row2["user_id"] . ">"
                        . " $outputString </a>";
                        //output the time
                        date_default_timezone_set('America/Halifax');
                        $postDate = new DateTime($row["date"]);
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
                        echo " <b>retweeted from " . $row["first_name"] . " " . $row["last_name"] . "</b>";
                        //content of the tweet
                        echo "<p>" . $row["tweet_text"] . "</p>";
                        //buttons
                        if ($this->CheckLiked($row["tweet_id"], $_SESSION["SESS_MEMBER_ID"])) {
                            echo "<img class=\"smallicon\" src=\"images/liked.png\">";
                        } else {
                            echo "<a href=\"liketweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/like.ico\"></a>";
                        }
                        echo "<a href=\"retweet.php?tweet_id=" . $row["tweet_id"] . "\"><img class=\"smallicon\" src=\"images/retweet.png\"></a>";
                        echo '<p id="submit_comment_link"><a href="#" data-id="' . $row["tweet_id"] . '" >Submit a comment!</a></p>';
                        $this->getReplys($row["tweet_id"]);
                        echo "<HR>";
                    }
                }
            }
        }
    }

    public function CheckLiked($tweetid, $userid) {
        global $con;
        $sql = "select * from likes where tweet_id = $tweetid and user_id = $userid";
        mysqli_query($con, $sql);
        if (mysqli_affected_rows($con) < 1) {
            return false;
        } else {
            return true;
        }
    }

    public function GetLikeNotifications() {
        global $con;
        //get tweets that are yours, or that you have followed
        $sql = "SELECT *, DATE_FORMAT(likes.date_created, '%m/%d/%y %T') AS date from likes "
                . "INNER JOIN tweets on likes.tweet_id = tweets.tweet_id INNER JOIN users on users.user_id = likes.user_ID where tweets.user_id = " . $_SESSION["SESS_MEMBER_ID"]
                . " ORDER BY likes.date_created DESC";
        //echo $sql;
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                //output the name
                //echo $row["original_tweet_id"];
                if ($row["original_tweet_id"] == 0) {
                    $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                    $outputString = substr($outputString, 0, 25);
                    if ($row["profile_pic"] != "") {
                        echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                        . "<img class=\"bannericons\" src=\"images/profilepics/" . $row["user_id"] . "/" . $row["profile_pic"] . "\"> $outputString </a>";
                    } else {
                        echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                        . "<img class=\"bannericons\" src=\"images/profilepics/default.jfif\"> $outputString </a>";
                    }
                    echo " liked your tweet ";
                    //output the time
                    date_default_timezone_set('America/Halifax');
                    $postDate = new DateTime($row["date"]);
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
                    echo "<br><br><p>" . $row["tweet_text"] . "</p>";
                    echo "<HR>";
                } else if ($row["original_tweet_id"] != 0) {
                    $sql2 = "SELECT users.user_id, users.first_name, users.last_name, users.screen_name, users.profile_pic FROM USERS INNER JOIN TWEETS ON users.user_id = tweets.user_id WHERE tweets.tweet_id = " . $row["original_tweet_id"];
                    $result2 = mysqli_query($con, $sql2);
                    if ($row2 = mysqli_fetch_array($result2)) {
                        $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                        $outputString = substr($outputString, 0, 25);
                        if ($row["profile_pic"] != "") {
                            echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                            . "<img class=\"bannericons\" src=\"images/profilepics/" . $row["user_id"] . "/" . $row["profile_pic"] . "\"> $outputString </a>";
                        } else {
                            echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                            . "<img class=\"bannericons\" src=\"images/profilepics/default.jfif\"> $outputString </a>";
                        }
                        echo " liked your tweet ";
                        //output the time
                        date_default_timezone_set('America/Halifax');
                        $postDate = new DateTime($row["date"]);
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
                        $u = new User();
                        $u->getUserById($_SESSION['SESS_MEMBER_ID']);
                        echo " <br><b>retweeted from " . $u->firstName . " " . $u->lastName . "</b>";
                        //content of the tweet
                        echo "<br><br><p>" . $row["tweet_text"] . "</p>";
                        echo "<HR>";
                    }
                }
            }
        }
    }

    public function GetRetweetNotifications() {
        global $con;
        //get tweets that are yours, or that you have followed
        $sql = "SELECT *, DATE_FORMAT(retweets.date_created, '%m/%d/%y %T') AS date, origtweets.original_tweet_id as origorigtweetid, origtweets.tweet_text as origtweettext from tweets origtweets "
                . "INNER JOIN tweets retweets on retweets.original_tweet_id = origtweets.tweet_id INNER JOIN users on users.user_id = retweets.user_ID where origtweets.user_id = " . $_SESSION["SESS_MEMBER_ID"]
                . " ORDER BY retweets.date_created DESC";
        //echo $sql;
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                //output the name
                //echo $row["original_tweet_id"];
                if ($row["origorigtweetid"] == 0) {
                    $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                    $outputString = substr($outputString, 0, 25);
                    if ($row["profile_pic"] != "") {
                        echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                        . "<img class=\"bannericons\" src=\"images/profilepics/" . $row["user_id"] . "/" . $row["profile_pic"] . "\"> $outputString </a>";
                    } else {
                        echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                        . "<img class=\"bannericons\" src=\"images/profilepics/default.jfif\"> $outputString </a>";
                    }
                    echo " retweeted your tweet ";
                    //output the time
                    date_default_timezone_set('America/Halifax');
                    $postDate = new DateTime($row["date"]);
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
                    echo "<br><br><p>" . $row["origtweettext"] . "</p>";
                    echo "<HR>";
                } else if ($row["origorigtweetid"] != 0) {
                    $sql2 = "SELECT users.user_id, users.first_name, users.last_name, users.screen_name, users.profile_pic FROM USERS INNER JOIN TWEETS ON users.user_id = tweets.user_id WHERE tweets.tweet_id = " . $row["origorigtweetid"];
                    $result2 = mysqli_query($con, $sql2);
                    if ($row2 = mysqli_fetch_array($result2)) {
                        $outputString = $row2["first_name"] . " " . $row2["last_name"] . " @" . $row2["screen_name"];
                        $outputString = substr($outputString, 0, 25);
                        if ($row2["profile_pic"] != "") {
                            echo "<a href=http://localhost/userpage.php?user_id=" . $row2["user_id"] . ">"
                            . "<img class=\"bannericons\" src=\"images/profilepics/" . $row2["user_id"] . "/" . $row2["profile_pic"] . "\"> $outputString </a>";
                        } else {
                            echo "<a href=http://localhost/userpage.php?user_id=" . $row2["user_id"] . ">"
                            . "<img class=\"bannericons\" src=\"images/profilepics/default.jfif\"> $outputString </a>";
                        }
                        echo " retweeted your tweet ";
                        //output the time
                        date_default_timezone_set('America/Halifax');
                        $postDate = new DateTime($row["date"]);
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
                        echo " <br><b>retweeted from " . $row["first_name"] . " " . $row["last_name"] . "</b>";
                        //content of the tweet
                        echo "<br><br><p>" . $row["origtweettext"] . "</p>";
                        echo "<HR>";
                    }
                }
            }
        }
    }
    
    public function GetReplyNotifications(){
        global $con;
        //get tweets that are yours, or that you have followed
        $sql = "SELECT *, DATE_FORMAT(replys.date_created, '%m/%d/%y %T') AS date, origtweets.original_tweet_id as origorigtweetid, origtweets.tweet_text as origtweettext from tweets origtweets "
                . "INNER JOIN tweets replys on replys.reply_to_tweet_id = origtweets.tweet_id INNER JOIN users on users.user_id = replys.user_ID where origtweets.user_id = " . $_SESSION["SESS_MEMBER_ID"]
                . " ORDER BY replys.date_created DESC";
        //echo $sql;
        if ($result = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                //output the name
                //echo $row["original_tweet_id"];
                if ($row["origorigtweetid"] == 0) {
                    $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                    $outputString = substr($outputString, 0, 25);
                    if ($row["profile_pic"] != "") {
                        echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                        . "<img class=\"bannericons\" src=\"images/profilepics/" . $row["user_id"] . "/" . $row["profile_pic"] . "\"> $outputString </a>";
                    } else {
                        echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                        . "<img class=\"bannericons\" src=\"images/profilepics/default.jfif\"> $outputString </a>";
                    }
                    echo " replied to your tweet ";
                    //output the time
                    date_default_timezone_set('America/Halifax');
                    $postDate = new DateTime($row["date"]);
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
                    echo "<br><br><p>" . $row["origtweettext"] . "</p>";
                    echo "<HR>";
                } else if ($row["origorigtweetid"] != 0) {
                    $sql2 = "SELECT users.user_id, users.first_name, users.last_name, users.screen_name FROM USERS INNER JOIN TWEETS ON users.user_id = tweets.user_id WHERE tweets.tweet_id = " . $row["origorigtweetid"];
                    $result2 = mysqli_query($con, $sql2);
                    if ($row2 = mysqli_fetch_array($result2)) {
                        $outputString = $row["first_name"] . " " . $row["last_name"] . " @" . $row["screen_name"];
                        $outputString = substr($outputString, 0, 25);
                        if ($row["profile_pic"] != "") {
                            echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                            . "<img class=\"bannericons\" src=\"images/profilepics/" . $row["user_id"] . "/" . $row["profile_pic"] . "\"> $outputString </a>";
                        } else {
                            echo "<a href=http://localhost/userpage.php?user_id=" . $row["user_id"] . ">"
                            . "<img class=\"bannericons\" src=\"images/profilepics/default.jfif\"> $outputString </a>";
                        }
                        echo " replied to your tweet ";
                        //output the time
                        date_default_timezone_set('America/Halifax');
                        $postDate = new DateTime($row["date"]);
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
                        $u = new User();
                        $u->getUserById($_SESSION['SESS_MEMBER_ID']);
                        echo " <br><b>retweeted from " . $u->firstName . " " . $u->lastName . "</b>";
                        //content of the tweet
                        echo "<br><br><p>" . $row["origtweettext"] . "</p>";
                        echo "<HR>";
                    }
                }
            }
        }
    }

}
