<?php
    $dbHost = 'localhost';
    $dbUsername = 'root'; 
    $dbPassword = '';
    $dbName = 'bancoecomap';

    //Variável de conexão
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 

    //Testar se a conexão foi bem sucedida (Deu certo)
    
      //  if ($conn->connect_error) {
      //      echo"Conexão falhou";
      //  }
      //  else {
      //      echo"Conexão bem sucedida";
      //  }

?>