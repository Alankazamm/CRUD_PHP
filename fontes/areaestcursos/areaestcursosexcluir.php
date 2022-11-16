<?php
require_once("../../funcoes/toolsbag.php");
require_once("./areaestcursosfuncoes.php");
$bloco = (ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
global $numconex;
$cordefundo="#48d1cc";
iniciapagina(TRUE,"&Aacuterea estudo/cursos","areaestcursos","Excluir");
montamenu("&Aacuterea estudo/cursos","areaestcursos","Excluir",$sair);

switch(TRUE){

    case ($bloco == 1):
        {
			picklist('E');
            break;
        }
    case ($bloco == 2):
        {

            mostrarregistro("$_REQUEST[idareaestudocurso]");
			printf("<form action='./areaestcursosexcluir.php' method='POST'>\n");
			printf("<input type='hidden' name='bloco' value='3'>\n");
			printf("<input type='hidden' name='sair' value='$sair'>\n");
			printf("<input type='hidden' name='idareaestudocurso' value='$_REQUEST[idareaestudocurso]'>\n");
			
			botoes('',TRUE,TRUE,TRUE,TRUE,TRUE);
			printf("</form>\n");
			
			
			break;
        }
	case ($bloco == 3) :
	{
			printf("Tratamento de Transação<br>\n");
			$cmdsql="DELETE FROM areaestcursos WHERE idareaestudocurso = '$_REQUEST[idareaestudocurso]'";
			$tentativa = TRUE;
			while($tentativa == TRUE){
				mysqli_query($numconex,"START TRANSACTION");
				mysqli_query($numconex,$cmdsql);
				if(mysqli_errno($numconex)==0){
					mysqli_query($numconex,"COMMIT");
					$mostrar=TRUE;
					$tentativa=FALSE;
									
				}
				else{
					
					if(mysqli_errno($numconex)==1213){
						
						mysqli_query($numconex,"ROLLBACK");
											
						
					}
					else{
						$msg = mysqli_errno($numconex)."-".mysqli_error($numconex);
						mysqli_query($numconex,"ROLLBACK");
						$tentativa=FALSE;
						
					}
					
					
				}
				if($mostrar=TRUE){
					  printf("Exclusão feita com sucesso!<br>\n");
				}
				else{
					printf("Erro! $msg<br>\n");
					
				}
				
				botoes("",FALSE,TRUE,TRUE,FALSE,TRUE);
				break;
			}
	}
}


terminapagina("&Aacuterea estudo/cursos","Excluir","areaestcursosexcluir.php");



?>