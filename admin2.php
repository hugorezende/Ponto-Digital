<!DOCTYPE html>
<?php
error_reporting(E_ALL ^ E_NOTICE);

if(isset ($_POST["data_ini"])){
  $data_ini = $_POST["data_ini"];
}

if(isset ($_POST["data_fim"])){
  $data_fim = $_POST["data_fim"];
}

if(isset ($_POST["id_func"])){
  $id_func = $_POST["id_func"];
}




?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <?php
include('functions.php');
$lista = get_funcionarios();

?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="bootstrap-3.1.1/bootstrap-3.1.1/assets/ico/favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.1.1/bootstrap-3.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


 <script>



  $(function() {

  <?php 

  if(isset ($_GET["id_func"])){
    $id_func = $_GET["id_func"];

    echo "$('#selected_func').val(".$id_func.");";

  }

  ?>
 
	
    $( "#datepicker_ini" ).datepicker();
    $( "#datepicker_ini" ).datepicker( "option", "dateFormat", "dd-mm-yy" );
	$( "#datepicker_end" ).datepicker();
  $( "#datepicker_end" ).datepicker( "option", "dateFormat", "dd-mm-yy" );
	
  });
  
  function show_datepcker(){
	
   $( "#div_date" ).show();
	 $("#bt_pesqusisar").attr('href',"admin.php?id_func="+$("#selected_func option:selected" ).val())
	 
  }
  </script>

  </head>

  <body >
  
 
 
	
    <div class="container" style="width:600px;">
   
    
   
  

<h2 class="form-signin-heading">Selecione Usuário</h2>
<form action="admin2.php" method="GET">

      <select id="selected_func" name="id_func" class="form-control">
      <option>Escolha o funcionário</option>
      <?php 
  	   for($i=0; $i<sizeof($lista); $i++){
		      echo '<option value='.$lista[$i]['idfuncionario'].'>'.$lista[$i]['nome'].'</option>';
	     }
	     ?>
	
      </select>
      <br><br>
	     <div id="div_date" style="">
       <p>Data Inicial: <input name="data_ini" id="datepicker_ini"></p>
       <p>Data Inicial: <input name="data_fim"id="datepicker_end"></p>

       <button type="submit" value="Submit" class="btn btn-success">Pesquisar</button>
   
    
  </form>
    <?php 
	
	if(isset($_GET['id_func'])){
			?>
            <script> show_datepcker();</script>
            <?php
		    echo "<br><br>";
			//echo "<h2>Tempo trabalhado: ". calc_time($_GET['id_func'])."</h2>";
	}
	
	?>
    
    </div>
    
    <?php
    echo date("Y-m-d", strtotime($data_ini));
    listaEntradaSaida($id_func,date("Y-m-d", strtotime($data_ini)),date("Y-m-d", strtotime($data_fim)));

    echo "<h2>";
    echo totalHoras($id_func,date("Y-m-d", strtotime($data_ini)),date("Y-m-d", strtotime($data_fim)));
    echo "</h2>";
    echo"<br>";
    getTotalHoras($id_func,date("Y-m-d", strtotime($data_ini)),date("Y-m-d", strtotime($data_fim)));
    ?>



    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    







  </body>
</html>