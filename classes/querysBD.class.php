<?PHP
class querysBD{
    private $values;
    private $campos;
    private $tabela;
    private $bd;
    private $mensagem = 0;
    private $sqlSelect = "SELECT %s FROM %s WHERE %s %s '%s'";
    private $sqlSelectInnerJoin = "SELECT %s FROM %s INNER JOIN %s ON %s = %s WHERE %s %s %s";
    private $sqlInsert = "INSERT INTO %s (%s) VALUES %s";
    private $sqlShowColumns= "SHOW COLUMNS FROM %s";
    private $sqlShowTables = "SHOW TABLES FROM %s";
    private $sqlDelete = "DELETE FROM %s WHERE %s %s '%s'";
    private $sqlUpdateMultiple = "UPDATE %s
                                        SET %s
                                            %s
                                        END 
                                      WHERE %s IN (%s)";
    
    private $sqlUpdateComplementar = " %s = CASE %s ";
    private $sqlUpdateLinhas = " WHEN %s THEN %s ";
     
    public function queryPropia($query, $boolean = false){
          $camposRetorno = "";
          $result = mysql_query($query);
          
          if($boolean === false){
               return $this->returnArrayAssoc($result, $camposRetorno);
          }elseif($boolean === true){
              return $result;
          }
    }
  
    public function selectInnerJoin($camposRetorno = "*", $tabelas, $campoParaComparacao, $condicao = "1", $operador = "=", $valorParaCondicao = "1"){
        if($camposRetorno == "*"){
            $camposRetorno = array("*");
        }
        $camposList = "";
        for($a=0; sizeof($camposRetorno) > $a; $a++){
            $camposList = $camposList.$camposRetorno[$a].", ";
        }
        
        $camposList = rtrim($camposList, ", ");
        $comparacao0 = $tabelas[0].".".$campoParaComparacao[0];
        $comparacao1 = $tabelas[1].".".$campoParaComparacao[1];
        $stringFinal = sprintf($this->sqlSelectInnerJoin, $camposList, $tabelas[0], $tabelas[1],$comparacao0, $comparacao1,$condicao, $operador, $valorParaCondicao);
        $result = mysql_query($stringFinal);
        return $this->returnArrayAssoc($result, $camposRetorno);
       
    }
    public function select($tabela, $camposRetorno = "*", $condicao = "1", $operador = "=", $valorParaCondicao = "1"){
        if($camposRetorno == "*"){
            $camposRetorno = array("*");
        }
        if(!is_array($camposRetorno)){
            $camposRetorno = array($camposRetorno);
        }
        
        $camposList = "";
        for($a=0; sizeof($camposRetorno) > $a; $a++){
            $camposList = $camposList.$camposRetorno[$a].", ";
        }
        $camposList = rtrim($camposList, ", ");
        $stringFinal = sprintf($this->sqlSelect, $camposList, $tabela, $condicao, $operador, $valorParaCondicao); 
        
        $result = mysql_query($stringFinal);
        //return $stringFinal;
        if($result != false){
            return $this->returnArrayAssoc($result, $camposRetorno);
        }else{
            return "erro";
        }

    }

    public function updateMultiple($tabela, $campos, $valores, $campoCondicao, $valorCondicao){
        $linhasParaAtualizar = "";
        $listaValoresParaCondicao = "";
        for($b=0; sizeof($valores) > $b; $b++){
            $linhasParaAtualizar = $linhasParaAtualizar . sprintf($this->sqlUpdateLinhas, $valorCondicao[$b], $valores[$b]);
        }
        
        for($c=0; sizeof($valores) > $c; $c++){
            $listaValoresParaCondicao = $listaValoresParaCondicao.$valorCondicao[$c].", ";
        }
        $listaValoresParaCondicao = rtrim($listaValoresParaCondicao,', ');
        $complementar = sprintf($this->sqlUpdateComplementar, $campos, $campoCondicao);      
        $strigFinal = sprintf($this->sqlUpdateMultiple, $tabela, $complementar, $linhasParaAtualizar, $campoCondicao, $listaValoresParaCondicao);    
     
      
        return mysql_query($strigFinal);
        //return $strigFinal;
    }

    public function insert($tabela, $campos, $valores){
        if(!is_array($campos)){
            $campos = array($campos);
        }
        if(!is_array($valores)){
            $valores = array(
                'valor'=> array($valores)
            );
        }
        $stringCampos = "";
        $stringValues = "";
        $chaves = array_keys($valores);
        
        for($a=0;sizeof($campos) > $a; $a++){
            $stringCampos .= $campos[$a].", "; 
        }
        
        $key = array_keys($valores);        
        $qtdeInserts = (sizeof($key)* sizeof($valores[$key[0]])) / sizeof($campos);
        
        for($b=0;sizeof($valores[$key[0]]) > $b; $b++){
            $stringValues = "";
            for($c=0;sizeof($campos) > $c; $c++){
                if(is_int($valores[$chaves[$c]][$b])){
                   $stringValues .= $valores[$chaves[$c]][$b].", ";  
                }else{
                   $stringValues .= "'".$valores[$chaves[$c]][$b]."', ";  
                }
             }
             
             $stringValues = rtrim($stringValues,', ');
             $parenteses[] = sprintf("(%s)",$stringValues);
        }
        $addPatenses = "";
        for($e = 0; sizeof($parenteses) > $e; $e++){
              $addPatenses .= $parenteses[$e].",";
        }
        
        $stringValues = rtrim($addPatenses,', ');
        $stringCampos = rtrim($stringCampos,', ');

        $stringFinal = sprintf($this->sqlInsert, $tabela, $stringCampos, $stringValues);
        if(!mysql_query($stringFinal)){
            $this->mensagem = 2;
        }else{
            $this->mensagem = 1;
        }
       
       return $this->errosList($this->mensagem);
      // return $stringFinal;
    }
    
    public function delete($tabela, $campoCondicao, $operador = "=", $valorCondicao){
        $valor = "";
        for($a=0; sizeof($valorCondicao) > $a; $a++){
             $valor = $valor.$valorCondicao[$a].",";
        }
        $valor = rtrim($valor,', ');
        $stringFinal = sprintf($this->sqlDelete, $tabela, $campoCondicao,$operador,  $valor);
        if(mysql_query($stringFinal)){
            $retorno = true;
        }else{
            $retorno = false;
        }
        return $retorno;
    }
    public function returnArrayAssoc($resulMySQL, $camposRetorno){
        $result = $resulMySQL;
        
        while($arrayAssoc = mysql_fetch_assoc($result)){
            if(sizeof($camposRetorno) == 1){
                $resultado[] = $arrayAssoc;
            }else{
                for($a = 0; sizeof($camposRetorno) > $a; $a++){
                    $resultado[$camposRetorno[$a]][] = $arrayAssoc[$camposRetorno[$a]];
                }
            }
        }
        if(!isset($resultado)){
            $resultado = $arrayAssoc;
        }
        return $resultado;
    }
    
//    function __construct($values, $campos, $tabela,$bd){
//        $this->values = $values;
//        $this->campos = $campos;
//        $this->tabela = $tabela;
//        $this->bd = $bd;
//    }
 
//    function set_name($values){
//        $this->values = $values;
//    }
//    function get_name(){
//        return $this->values;
//    }
//    function set_campos($campos){
//        $this->campos = $campos;
//    }
//    function get_campos(){
//        return $this->campos;
//    }
//    function set_tabela($tabela){
//        $this->tabela = $tabela;
//    }
//    function get_tabela(){
//        return $this->tabela;
//    }
//    function set_bd($bd){
//        $this->bd = $bd;
//    }
//    function get_bd(){
//        return $this->bd;
//    }
    

    public function verificarTabela(){  
        $query = sprintf($this->sqlShowTables, $this->bd);
        $queryTabelas = mysql_query($query);
        while($resultado = mysql_fetch_array($queryTabelas)){
            $tabelas[] = $resultado[0]; 
        }
       //var_dump($tabelas);
        if(!in_array($this->tabela, $tabelas)){
            $this->mensagem = 6;
        }
        //echo $this->errosList($this->mensagem);
    }
    
   public function verificarCamposTabela(){
       $query = sprintf($this->sqlShowColumns, $this->tabela);
       $queryColunas = mysql_query($query);
        while($colunas = mysql_fetch_assoc($queryColunas)){
            $listaColunas[] = $colunas["Field"];
        }
        for($h=0;sizeof($this->campos) > $h;$h++){
            if(!in_array($this->campos[$h],$listaColunas)){
                $this->mensagem = 3;
            }   
        }
   }
   
   public function verificarQtdeChavesXCampos(){
       if(sizeof($this->values) != sizeof($this->campos)){
           $this->mensagem = 4;
       }
   }
   
   public function verificarQtdeValuesPorCampo(){
      $chavesArray = array_keys($this->values);
      $quantidadeValues = sizeof($this->values[$chavesArray[0]]);
      
      for($a=0;sizeof($this->values) > $a; $a++){
          if($quantidadeValues != sizeof($this->values[$chavesArray[$a]])){
              $this->mensagem = 5;
          }
      }
   }

   public function errosList($erroNumber){
        $errorList = array(
            "A variavel mensagem nao esta setada",
            "Inserção realizada com sucesso", 
            "Erro durante a execução da query", 
            "Um dos campos informados não estão presentes na Tabela",
            "A quantidade de campos informados não é igual a quantidade de chaves do array",
            "Alguma das chaves do array contém um quantidade diferentes de valores em relaçao as demais",
            "A tabela informada nao existe no banco de dados"
         );
         return $errorList[$erroNumber];
   }
   

//    public function updateMultiple($tabela, $campos, $valores, $campoCondicao){
//        
//    }
}
