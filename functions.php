<?php

include('connect.php');

function listar_pontos($id_func){
	
	$SQLa = "SELECT * FROM ponto WHERE funcionario_idfuncionario = ".$id_func." ORDER BY time DESC";
	$resulta = mysql_query($SQLa);
	
	$linhas[] = null;
	$i=0;
	while ($row = mysql_fetch_array($resulta)) {
    	$linhas[$i]['tipo'] = $row["tipo"];
		$linhas[$i]['time'] = $row["time"];
    	$i++;
	}
	
	return($linhas);
}


function listar_ultimos_pontos($id_func){
	
	$SQLa = "SELECT * FROM ponto WHERE funcionario_idfuncionario = ".$id_func." ORDER BY time DESC LIMIT 10";
	$resulta = mysql_query($SQLa);
	
	$linhas[] = null;
	$i=0;
	while ($row = mysql_fetch_array($resulta)) {
    	$linhas[$i]['tipo'] = $row["tipo"];
		$linhas[$i]['time'] = $row["time"];
    	$i++;
	}
	
	return($linhas);
}


function get_ultima($id_func){
	
	$SQLa = "SELECT tipo FROM ponto WHERE funcionario_idfuncionario = ".$id_func." ORDER BY time DESC LIMIT 1";
	$resulta = mysql_query($SQLa);
	
	$linhas[] = null;
	$i=0;
	while ($row = mysql_fetch_array($resulta)) {
    	$linhas = $row["tipo"];
		
	}
	
	return($linhas);
}


function registra_entrada($id_func){
	
	
	if(get_ultima($id_func)!=1){
	
	$SQLa = "INSERT INTO ponto (idponto, funcionario_idfuncionario, tipo, time) VALUES (NULL, ".$id_func.", '1', CURRENT_TIMESTAMP)";
	$resulta = mysql_query($SQLa) or die(mysql_error());
	}
	
	
}


function registra_saida($id_func){
	if(get_ultima($id_func)!=2){
	
	$SQLa = "INSERT INTO ponto (idponto, funcionario_idfuncionario, tipo, time) VALUES (NULL, ".$id_func.", '2', CURRENT_TIMESTAMP)";
	$resulta = mysql_query($SQLa) or die(mysql_error());;
	}
	
}


function get_funcionarios(){
	
	$SQLa = "SELECT * FROM funcionario";
	$resulta = mysql_query($SQLa);
	
	$linhas[] = null;
	$i=0;
	while ($row = mysql_fetch_array($resulta)) {
    	$linhas[$i]['idfuncionario'] = $row["idfuncionario"];
		$linhas[$i]['nome'] = $row["nome"];
    	$i++;
	}
	
	return($linhas);
}


//function calc_time($id_func,$startdate,$enddate){
function calc_time($id_func){

	$SQLa = "SELECT * FROM ponto WHERE funcionario_idfuncionario = ".$id_func." ORDER BY time";
	$resulta = mysql_query($SQLa);
	
	$linhas[] = null;
	$i=0;
	$total_tempo=0;
	while ($row = mysql_fetch_array($resulta)) {
    	$linhas[$i]= $row["time"];
		$i++;
	}
	
	for($t=0;$t<sizeof($linhas)/2;$t++){
		
		//verifica se existe o proximo
		if(isset($linhas[$t*2+1])){
			
			$startdate = $linhas[$t*2];
			$enddate = $linhas[$t*2+1];
			$timestamp_start = strtotime($startdate);
			$timestamp_end = strtotime($enddate);
			$difference = abs($timestamp_end - $timestamp_start); // that's it!
			
			$total_tempo= $total_tempo +$difference;
		
		}
	}
	
	
	
	
	
	return gmdate("H:i:s", $total_tempo);
	
	$startdate = '2014-03-31 18:01:13';
	$enddate = '2014-03-31 15:38:53';

	//$timestamp_start = strtotime($startdate);
	//$timestamp_end = strtotime($enddate);
	//$difference = abs($timestamp_end - $timestamp_start); // that's it!
	//return gmdate("H:i:s", $difference);
}

function diferencaTime_n($data_inicial,$data_final){
	$time_inicial = strtotime($data_inicial);
	$time_final = strtotime($data_final);
	// Calcula a diferença de segundos entre as duas datas:
	$diferenca = $time_final - $time_inicial;

	return $diferenca;
	
}


function diferencaTime($data_inicial,$data_final){
	$time_inicial = strtotime($data_inicial);
	$time_final = strtotime($data_final);
	// Calcula a diferença de segundos entre as duas datas:
	$diferenca = $time_final - $time_inicial;

	return gmdate("H:i:s", $diferenca);
	
}


function totalHoras($id_func,$dataIni,$dataFin){

	$total_tempo = 0;

	$dataFin = new DateTime($dataFin);
	$dataFin->modify('+1 day');
	$dataFin = $dataFin->format('Y-m-d');

	$SQLa = "SELECT * FROM ponto WHERE funcionario_idfuncionario = ".$id_func." AND time >= '".$dataIni."' AND time <= '".$dataFin."' ORDER BY time DESC";
	$resulta = mysql_query($SQLa);

	while ($row = mysql_fetch_array($resulta)) {

		$listagem[] =$row;  
    	

    	
	}
	
	for ($i=0; $i < count($listagem); $i++) { 
		
		if($listagem[$i]["tipo"]==2){
			//echo $i;
			//if($listagem[$i+1]["tipo"]==1){
				//echo diferencaTime_n($listagem[$i+1]['time'],$listagem[$i]['time'])."<br>";
				$total_tempo = $total_tempo + diferencaTime_n($listagem[$i+1]['time'],$listagem[$i]['time']);

			//}
			

		}



	}
	

	echo("<br>Tempo total: ");

	echo (floor($total_tempo / 3600)) . ":";
	
	echo floor(($total_tempo % 3600)/60). ":";

	echo (($total_tempo % 3600)%60);


	//echo (floor(($total_tempo % 3600)/60);
	//return gmdate("d:h:i:s", $total_tempo);


}



function getFeriados($dataIni,$dataFin){


	$SQLa ="SELECT * FROM `feriado` WHERE `data`>= '".$dataIni."' AND `data`<= '".$dataFin."'";

	$resulta = mysql_query($SQLa);

	while ($row = mysql_fetch_array($resulta)) {

		$listagem[] =$row["data"];  
   	
    	
	}
	return $listagem;

}




function getTotalHoras($id_func,$dataIni,$dataFin){



	$SQLa = "SELECT horas_dia FROM funcionario WHERE idfuncionario = ".$id_func;

	$resulta = mysql_query($SQLa);

	while ($row = mysql_fetch_array($resulta)) {

		$listagem[] =$row;  
	
	}


		$start = new DateTime($dataIni);
		$end = new DateTime($dataFin);
		// otherwise the  end date is excluded (bug?)
		$end->modify('+1 day');

		$interval = $end->diff($start);

		// total days
		$days = $interval->days;

		// create an iterateable period of date (P1D equates to 1 day)
		$period = new DatePeriod($start, new DateInterval('P1D'), $end);

		// best stored as array, so you can add more than one

		

		$holidays = getFeriados($dataIni,$dataFin);

		foreach($period as $dt) {
		    $curr = $dt->format('D');

		    // for the updated question
		    if($holidays!=null){
			    if (in_array($dt->format('Y-m-d'), $holidays)) {
			       $days--;
			    }
			}

		    // substract if Saturday or Sunday
		    if ($curr == 'Sat' || $curr == 'Sun') {
		        $days--;
		    }
		}


		echo "Dias de trabalho mês: ".$days."<br>"; // 4
		echo "Horas no mês: ".$days*$listagem[0]["horas_dia"]; // 4

}







function listaEntradaSaida($id_func,$dataIni,$dataFin){
	$diaSemana = array('Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado');

	$dataFin = new DateTime($dataFin);
	$dataFin->modify('+1 day');
	$dataFin = $dataFin->format('Y-m-d');

	

	$SQLa = "SELECT * FROM ponto WHERE funcionario_idfuncionario = ".$id_func." AND time >= '".$dataIni."' AND time <= '".$dataFin."' ORDER BY time DESC";

	$resulta = mysql_query($SQLa);

	while ($row = mysql_fetch_array($resulta)) {

		$listagem[] =$row;  
    	

    	
	}

	echo '<table width="600" border="1" style="padding:5px;">';

		echo '<tr>';
    	echo 	'<td>Entrada</td>';
    	echo 	'<td>Saída</td>';
    	echo 	'<td>Horas Trabalhadas</td>';
  		echo '</tr>';


  	$dia = true;
  	$bg = "style='background:#DADADA;'";

	for ($i=0; $i < count($listagem); $i++) { 

		

		
		if($listagem[$i]["tipo"]==2){
			
			

			echo '<tr '.$bg.'>';
    		echo 	'<td>'.$diaSemana[date('w', strtotime( $listagem[$i+1]['time']))]." - ".$listagem[$i+1]['time'].'</td>';
    		echo 	'<td>'.$diaSemana[date('w', strtotime( $listagem[$i]['time']))]." - ".$listagem[$i]['time'].'</td>';
    		echo 	'<td>'.diferencaTime($listagem[$i+1]['time'],$listagem[$i]['time']).'</td>';
  			echo '</tr>';


  			if(date('w', strtotime( $listagem[$i]['time'])) != date('w', strtotime( $listagem[$i+2]['time']))){
					$dia = !$dia;
			}

			if($dia){
				$bg = "style='background:#DADADA;'";
			}else{
				$bg = "";
			}

  			
  			
  			$i++;

		}else{

			

			echo '<tr '.$bg.'>';
    		echo 	'<td>'.$diaSemana[date('w', strtotime( $listagem[$i]['time']))]." - ".$listagem[$i]['time'].'</td>';
    		echo 	'<td></td>';
  			echo '</tr>';

  			if(date('w', strtotime( $listagem[$i]['time'])) != date('w', strtotime( $listagem[$i+2]['time']))){
					$dia = !$dia;
			}

			if($dia){
				$bg = "style='background:#DADADA;'";
			}else{
				$bg = "";
			}
  			
  			
  			

		}


	}

	echo '</table>';


	//echo"<pre>";
	//print_r($listagem);
	//echo"</pre>";



}



?>