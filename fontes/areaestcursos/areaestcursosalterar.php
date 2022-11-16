<?php
$bloco = (isset($_REQUEST['bloco'])) ? $_REQUEST['bloco'] : 1;
$sair = $_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
require_once("./areaestcursosfuncoes.php");
require_once("../../funcoes/toolsbag.php");
$cordefundo = 'FFDEAD';
iniciapagina(TRUE,"&Aacuterea estudo/cursos","areaestcursos","Alterar");
montamenu("&Aacuterea estudo/cursos","areaestcursos","Alterar",$sair);
	switch(TRUE){
		
		case ($bloco == 1):{
			
			picklist("A");
			break;
					
		}
		
		case ($bloco == 2):{
			
			$reglido = mysqli_fetch_array(mysqli_query($numconex,"SELECT a.*, c.idcurso, c.txnomecurso, b.idareaestudo, b.txnomearea FROM areaestcursos a, cursos c, areaestudos b WHERE idareaestudocurso = '$_REQUEST[idareaestudocurso]' AND c.idcurso = a.cursoid  AND b.idareaestudo = a.areaestudoid"));
			printf("<form action='./areaestcursosalterar.php' method='POST'>");
			printf("<input type='hidden' name='bloco' value='3'>");
			printf("<input type='hidden' name='sair' value='$sair'>\n");
			printf("<input type='hidden' name='idareaestudocurso' value='$_REQUEST[idareaestudocurso]'>");
			printf("<table>");
			$cmdsql="SELECT idcurso, txnomecurso FROM cursos";
			$exccmd=mysqli_query($numconex,$cmdsql);

			printf("<tr><td>Curso:</td><td><select name='cursoid'>");
			 while($reg=mysqli_fetch_array($exccmd)){

				$selected=( $reg['idcurso']==$reglido['cursoid'] ) ? " SELECTED": "" ;
				printf("<option value='$reg[idcurso]'$selected>$reg[txnomecurso]-($reg[idcurso])</option>\n");
			 }
			printf("</select></td></tr>");

			$cmdsql="SELECT idareaestudo, txnomearea FROM areaestudos";
			$exccmd=mysqli_query($numconex,$cmdsql);
			printf("<tr><td>Área de Estudo: </td><td><select name='areaestudoid'>");
			 while($reg=mysqli_fetch_array($exccmd)){

				$selected=( $reg['idareaestudo']==$reglido['areaestudoid'] ) ? " SELECTED": "" ;
				printf("<option value='$reg[idareaestudo]'$selected>$reg[txnomearea]-($reg[idareaestudo])</option>\n");
			 }
			printf("</select></td></tr>");
			printf("<tr><td>Data de cadastro: </td><td><input type='date' name='dtcadareaestudocurso' ></td></tr></table>");
			botoes("",TRUE,TRUE,TRUE,TRUE,TRUE);
			 printf("</form>");
			
			break;
		}
		case ( $bloco==3 ):
			{ # Executando a transação (ALTERAÇÃO dos dados do registro de médico que foi alterado no 'case 2').
			  $cmdsql="UPDATE areaestcursos
							  SET cursoid         = '$_REQUEST[cursoid]',
							  areaestudoid      = '$_REQUEST[areaestudoid]',
							  dtcadareaestudocurso='$_REQUEST[dtcadareaestudocurso]'
							  WHERE
							  idareaestudocurso='$_REQUEST[idareaestudocurso]'";
			  # printf("$cmdsql\n"); # deixe este comando sem comentario para 'ver' o comando SQL em tmepo de execução.
			  $tentativa=TRUE;
			  while ( $tentativa )
			  {
				# Avisando o inicio:
				mysqli_query($numconex,"START TRANSACTION");
				mysqli_query($numconex,$cmdsql);
				# no php o texto do erro vem na função _error() e o numero do erro vem na função _errno()
				if ( mysqli_errno($numconex)==0 )
				{ # SEM ERRO! SE NÃO deu ERRO ... então a transação deve ser CONCLUIDA (E não mais tentada).
				  # Concluindo a transação
				  mysqli_query($numconex,"COMMIT");
				  # 'destentar' a transação
				  $mostra=TRUE;
				  $tentativa=FALSE;
				}
				else
				{
				  $mostra=FALSE; 
				  if ( mysqli_errno($numconex)==1213 ) # Este é o numero do erro DEADLOCK
				  { # Se deu erro na tentativa de executar o comando... e o erro for um DEADLOCK, então
					# deve-se cancelar a transação e a seguir reinicia-la.
					# CANCELANDO a transação
					mysqli_query($numconex,"ROLLBACK");
					# 'destentar' a transação
					$tentativa=TRUE;
				  }
				  else
				  { # Se DEU erro e não foi DEADLOCK... a transação deve ser CANCELADA e NÃO dever ser reiniciada
					# CANCELANDO a transação
					$mens=mysqli_errno($numconex)." - ".mysqli_error($numconex);
					mysqli_query($numconex,"ROLLBACK");
					# 'destentar' a transação
					$tentativa=FALSE;
				  }
				}
			  }
			  if ( $mostra )
			  { # Transação acabou com sucesso
				printf("Alteração feita com sucesso!\n");
				mostrarregistro("$_REQUEST[idareaestudocurso]");
			  }
			  else
			  {
				printf("Erro! $mens<br>\n");
			  }
			    botoes("",FALSE,TRUE,TRUE,FALSE,TRUE);
			  break;
			}
		
		
	}


terminapagina("&Aacuterea estudo/cursos","Alterar","areaestcursosalterar.php");





?>