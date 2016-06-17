<?php
session_start();
include('functions.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="bootstrap-3.1.1/bootstrap-3.1.1/assets/ico/favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.1.1/bootstrap-3.1.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script>
function startTime()
{
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
// add a zero in front of numbers<10
m=checkTime(m);
s=checkTime(s);
document.getElementById('clock').innerHTML=h+":"+m+":"+s;
t=setTimeout(function(){startTime()},500);
}

function checkTime(i)
{
if (i<20)
  {
  i="0" + i;
  }
return i;
}
</script>


  </head>

  <body onload="startTime()">
  
 
  <?php
  if(isset($_POST['login'])){
    

    $login = isset( $_POST['login'] )? trim($_POST['login']) : false;
    $senha = isset( $_POST['senha'] )? trim($_POST['senha']) : false;

    if( $login && $senha ){
        $SQLa = "SELECT * FROM funcionario WHERE nome = '".$login."' AND senha = '".$senha."'";
        $resulta = mysql_query($SQLa);
        $lista = mysql_fetch_array($resulta);

        if(sizeof($lista)>0){

                $_SESSION["id"] = $lista['idfuncionario']; 
                $_SESSION["nome"] = $lista['nome']; 
        }
    }
    
    
  }
  
  ?>
	
    <div class="container" style="width:600px;">
    <div style="text-align:right"><a href="logout.php" class="btn btn-danger">Logout</a></div>
    
    <div style="text-align:center; font-size:48px;" id="clock"></div>
   
     <?php
	 
	//echo "<h2>Você está logado como: ". $_SESSION["nome"]."</h2>";

  if(isset($_SESSION["id"])){
	
	echo ' <table class="table"><thead><tr>';          
          echo '<th>Entrada/sa&iacute;da</th>';
          echo '<th>Hora</th>';
          
        echo '</tr>';
     echo ' </thead>';
     echo ' <tbody>';
	  
  	echo '<div style="width:200px; margin: 0 auto;">';
	if(get_ultima($_SESSION["id"]) == 1){
	echo '<div style="float:left; margin: 10px;"><a class="btn btn-success" disabled="disabled">Entrada</a></div>';
	echo '<div style="float:left; margin: 10px;"><a href="registra_saida.php?id_func='.$_SESSION["id"].'" class="btn btn-danger">Sa&iacute;da</a></div>';
	}else{
	
	echo '<div style="float:left; margin: 10px;"><a href="registra_entrada.php?id_func='.$_SESSION["id"].'" class="btn btn-success">Entrada</a></div>';
	echo '<div style="float:left; margin: 10px;"><a class="btn btn-danger" disabled="disabled">Saída</a></div>';
	
	
	}
	echo '</div>';
	
	
	
	$lista = (listar_ultimos_pontos($_SESSION["id"]));
	
	
	
	for($i=0; $i<sizeof($lista); $i++){
	
	
	
		 if ($lista[$i]['tipo'] == 1){
			  echo '<tr class="success">';
		 			 echo '<td><span class="glyphicon glyphicon-arrow-down"></span></td>';
         			 echo '<td>'.$lista[$i]['time'].'</td>';
			  echo '</tr>';
		 }else{
		 	   echo '<tr class="danger">';
		 	 		echo '<td><span class="glyphicon glyphicon-arrow-up"></span></td>';
         	 		echo '<td>'.$lista[$i]['time'].'</td>';
			  echo '</tr>';
		 
		 
		 }
		 ?>
         
         
          
       
       
     
    <?php
	
	}
	 
	?>
     </tbody>
    </table>
    <?php
	
	
  }else{
  
  ?>
<h2 class="form-signin-heading">Logar</h2>
      <form action="index.php" method="post">
        
        <input name="login" type="text" class="form-control" placeholder="Login">
        <input name="senha" type="password" class="form-control" placeholder="Senha" >
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Lembrar
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Logar</button>
      </form>
      
      <?php
  }
  ?>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
