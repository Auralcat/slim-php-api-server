<?php
// Here's where our DB connection params go.

class db
{
    private $dbhost = '127.0.0.1';
    private $dbuser = 'your_user_goes_here';
    private $dbpass = 'your_password_goes_here';
    private $dbname = 'slimapp';

    public function connect()
    {
        $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname;";
        $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}
?>
