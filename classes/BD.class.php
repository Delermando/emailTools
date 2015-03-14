<?PHP
class BD{
    private $host;
    private $user;
    private $pass;
    protected $dbname;
    
    function __construct($host, $user, $pass, $dbname){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->conectar();
    }

    public function conectar(){ 
        $conexao = mysql_connect($this->host, $this->user, $this->pass) or die(mysql_error());
        $select = mysql_select_db($this->dbname);
        //header('Content-Type: text/html; charset=utf-8');
        mysql_query("SET NAMES 'utf8'");
        mysql_query('SET character_set_connection=utf8');
        mysql_query('SET character_set_client=utf8');
        mysql_query('SET character_set_results=utf8');
        
        return $conexao;
    }	
}
