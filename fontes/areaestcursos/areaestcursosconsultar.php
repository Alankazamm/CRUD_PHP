<?php
require_once("../../funcoes/toolsbag.php");
require_once("./areaestcursosfuncoes.php");
$bloco = (ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];

$cordefundo="#FFDEAD";
iniciapagina(TRUE,"&Aacuterea estudo/cursos","areaestcursos","Consultar");
montamenu("&Aacuterea estudo/cursos","areaestcursos","Consultar",$sair);

switch(TRUE){

    case ($bloco == 1):
        {
			picklist('C');
            break;
        }
    case ($bloco == 2):
        {

            mostrarregistro("$_REQUEST[idareaestudocurso]\n");
			botoes("",FALSE,TRUE,TRUE,FALSE,TRUE);
			break;



        }



}


terminapagina("&Aacuterea estudo/cursos","Consultar","areaestcursosconsultar.php");



?>