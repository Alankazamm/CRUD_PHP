<?php
require_once("../../funcoes/toolsbag.php");
require_once("./areaestcursosfuncoes.php");
$bloco=( !ISSET($_REQUEST['bloco']) ) ? 1 : $_REQUEST['bloco'];
$menu=$_REQUEST['sair'];
$sair=$_REQUEST['sair']+1;
$cordefundo=($bloco<3) ? TRUE : FALSE;

iniciapagina($cordefundo,"&Aacuterea estudo/cursos","areaestcursos","Listar");
montamenu("&Aacuterea estudo/cursos","areaestcursos","Listar",$sair);
switch (TRUE)
{
  case ( $bloco==1 ):
  {
    montamenu("&Aacuterea estudo/cursos","areaestcursos","Listar",$sair);
    printf(" <form action='./areaestcursoslistar.php' method='post'>\n");
    printf("  <input type='hidden' name='bloco' value=2>\n");
    printf("  <input type='hidden' name='sair' value='$sair'>\n");
    printf("  <table style='border-style:none;'>\n");
    printf("   <tr ><td colspan=2>Escolha a <b>ordem</b> como os dados serão exibidos no relatório:</td></tr>\n");
    printf("   <tr><td>Código da área de estudo do curso:</td><td>(<input type='radio' name='ordem' value='idareaestudocurso'>)</td></tr>\n");
    printf("   <tr><td>Nome do curso:</td><td>(<input type='radio' name='ordem' value='txnomecurso' checked>)</td></tr>\n");
    printf("   <tr><td colspan=2>Escolha valores para seleção de <b>dados</b> do relatório:</td></tr>\n");
  
    $cmdsql="SELECT DISTINCT  a.areaestudoid, b.txnomearea FROM areaestcursos a, areaestudos b WHERE b.idareaestudo = a.areaestudoid";
	$exccmd=mysqli_query($numconex,$cmdsql);
	printf("<tr><td>Área de Estudo: </td><td><select name='areaestudoid'>");
	
    printf("<option value='TODAS'>Todas</option>");
    while ( $reg=mysqli_fetch_array($exccmd) )
    {
      printf("<option value='$reg[areaestudoid]'$selected>$reg[txnomearea]-($reg[areaestudoid])</option>\n");
    }
    printf("<select>\n");
    printf("</td></tr>\n");
    
 
    $dtini="1901-01-01";
    $dtfim=date("Y-m-d");
    printf("<tr><td>Intervalo de datas de cadastro:</td><td><input type='date' name='dtcadini' value='$dtini'> até <input type='date' name='dtcadfim' value='$dtfim'></td></tr>");
    printf("   <tr><td></td><td>");
	
    botoes("",TRUE,TRUE,TRUE,TRUE,TRUE);
    printf("</td></tr>\n");
    printf("  </table>\n");
    break;
  }
  case ( $bloco==2 or $bloco==3 ):
  { 
   $selecao=" WHERE (M.dtcadareaestudocurso between '$_REQUEST[dtcadini]' and '$_REQUEST[dtcadfim]')";
    $selecao=( $_REQUEST['areaestudoid']!='TODAS' ) ? $selecao." AND M.areaestudoid='$_REQUEST[areaestudoid]'" : $selecao ;
	
    $cmdsql="SELECT * FROM (SELECT a.*, c.idcurso, c.txnomecurso, b.idareaestudo, b.txnomearea FROM areaestcursos a, cursos c, areaestudos b WHERE c.idcurso = a.cursoid  AND b.idareaestudo = a.areaestudoid) AS M".$selecao." ORDER BY $_REQUEST[ordem]";
    $execsql=mysqli_query($numconex,$cmdsql);
    # SE o bloco de execução for 2, então o menu DEVE aparecer no topo da tela.
    ($bloco==2) ?  montamenu("&Aacuterea estudo/cursos","areaestcursos","Listar",$sair): "";
    printf("<table  style=' border-collapse: collapse;border:1px solid;'>\n");
	
	
	
	
	
    # SELECT a.*, c.idcurso, c.txnomecurso, b.idareaestudo, b.txnomearea FROM areaestcursos a, cursos c, areaestudos b WHERE idareaestudocurso = '$_REQUEST[idareaestudocurso]' AND c.idcurso = a.cursoid  AND b.idareaestudo = a.areaestudoid
    
	
	
	
	printf(" <tr bgcolor='lightblue'style=' border-collapse: collapse;border:1px solid;'><td valign=top >Cod.</td>\n");
    printf("     <td valign=top style=' border-collapse: collapse;border:1px solid;'>Curso</td>\n");
    printf("     <td valign=top style=' border-collapse: collapse;border:1px solid;'>Área de estudo</td>\n");
    printf("     <td valign=top style=' border-collapse: collapse;border:1px solid;'>Dt.Cad.</td></tr>\n");
	
	  $corlinha="White";
    while ( $le=mysqli_fetch_array($execsql) )
    {
      printf("<tr bgcolor=$corlinha><td style=' border-collapse: collapse;border:1px solid;'>$le[idareaestudocurso]</td>\n");
      printf("   <td valign=top style=' border-collapse: collapse;border:1px solid;'>$le[txnomecurso]</td>\n");
      printf("   <td valign=top style=' border-collapse: collapse;border:1px solid;'>$le[txnomearea]</td>\n");
	  printf("   <td valign=top style=' border-collapse: collapse;border:1px solid;'>$le[dtcadareaestudocurso]</td></tr>\n");
     
      $corlinha=( $corlinha=="White" ) ? "Navajowhite" : "White";
    }
    printf("</table>\n");
    if ( $bloco==2 )
	{
	  printf("<form action='./areaestcursoslistar.php' method='POST' target='_NEW'>\n");
      printf(" <input type='hidden' name='bloco' value=3>\n");
      printf(" <input type='hidden' name='sair' value='$sair'>\n");
      # Aqui estão os parâmentros usados na formatação da Listagem
      printf(" <input type='hidden' name='areaestudoid' value=$_REQUEST[areaestudoid]>\n");
      printf(" <input type='hidden' name='dtcadini' value=$_REQUEST[dtcadini]>\n");
      printf(" <input type='hidden' name='dtcadfim' value=$_REQUEST[dtcadfim]>\n");
      printf(" <input type='hidden' name='ordem' value=$_REQUEST[ordem]>\n");
      # botoes($paravolta,$paramenu,$limpar,$acao)
      botoes("L",FALSE,TRUE,TRUE,FALSE,FALSE);
      printf("</form>\n");
    }
    else
    {
      printf("<hr>\n<button type='submit' onclick='window.print();'>&#x1f5a8;</button> - Corte a folha na linha acima.\n");
    }
    break;
  }
}
terminapagina("&Aacuterea estudo/cursos","Listar","areaestcursoslistar.php");
?>