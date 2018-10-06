<?php
class connectionClass extends mysqli{
    public $host="localhost",$dbname="bct_vms",$dbpass="BlinkingCursors@1213",$dbuser="bct_vms";
    public $con;

    public function __construct() {
        if($this->connect($this->host, $this->dbuser, $this->dbpass, $this->dbname)){
          
        }
        else
        {
            return "<h1>Error while connecting database</h1>";
        }
    }
}
