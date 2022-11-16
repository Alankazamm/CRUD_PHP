<?php


function picklist($PA){
	global $sair;
	global $numconex;
	
            printf("Caixa de seleção para area de estudo por curso:<br>\n");
            $cmdsql = "SELECT a.*, c.idcurso, c.txnomecurso, b.idareaestudo, b.txnomearea FROM areaestcursos a, cursos c, areaestudos b WHERE  c.idcurso = a.cursoid  AND b.idareaestudo = a.areaestudoid";
            $exccmd = mysqli_query($numconex,$cmdsql);
			$prg=($PA=="C") ? "areaestcursosconsultar.php" :(($PA=='A')? "areaestcursosalterar.php" : "areaestcursosexcluir.php");
            printf("<form action='./$prg' method='POST'>\n");
            printf("<input type='hidden' name='bloco' value='2'>\n");
			printf("<input type='hidden' name='sair' value='$sair'>\n");
            printf("<select name='idareaestudocurso'>\n");
            while($reg=mysqli_fetch_array($exccmd)){
                printf("<option value='$reg[idareaestudocurso]'>$reg[idareaestudocurso]-$reg[txnomecurso] ($reg[txnomearea])</option>\n");
            }
            printf("</select><br>\n");
			
             botoes($PA,FALSE,TRUE,TRUE,TRUE,TRUE);
            printf("</form>\n");
	
	
}

function mostrarregistro($id){
			global $numconex;
            $cmdsql="SELECT a.*, c.idcurso, c.txnomecurso, b.idareaestudo, b.txnomearea FROM areaestcursos a, cursos c, areaestudos b WHERE idareaestudocurso = '$id' AND c.idcurso = a.cursoid  AND b.idareaestudo = a.areaestudoid";
            $exccmd = mysqli_query($numconex,$cmdsql);
            $reg = mysqli_fetch_array($exccmd);
            printf("<table border=1 style='border-style:none;'>");
            printf("<tr style='border-style:none;'><td style='border-style:none;'>Código</td><td style='border-style:none;'>$reg[idareaestudocurso]</td></tr>\n");
            printf("<tr style='border-style:none;'><td style='border-style:none;'>Curso</td><td style='border-style:none;'>$reg[txnomecurso]</td></tr>\n");
            printf("<tr style='border-style:none;'><td style='border-style:none;'>Area de estudo</td><td style='border-style:none;'>$reg[txnomearea]</td></tr>\n");
            printf("<tr style='border-style:none;'><td style='border-style:none;'>Data de geração de registro:</td><td style='border-style:none;'>$reg[dtcadareaestudocurso]</td></tr>\n");
         
            printf("</table>\n");
}

function botoes($acao,$ticket,$paravolta,$paramenu,$limpar,$parasair)
{ # Monta as alternativas de botões: argumentos TRUE | FALSE para paravolta, paramenu e limpar. Uma LETRA para a acao (ICAEL).
  global $sair, $menu;
  $botoes='';
  $icone="";
  $icone=( $acao=="I") ? "<icob>&#x1f7a5;</icob>" : $icone;
  $icone=( $acao=="C") ? "<icob>&#x1f50d;&#xfe0e;</icob>" : $icone;
  $icone=( $acao=="A") ? "<icob>&#x1f589;</icob>" : $icone;
  $icone=( $acao=="E") ? "<icob>&#x1f7ac;</icob>" : $icone;
  $icone=( $acao=="L") ? "<icob>&#x1f5a8;</icob>" : $icone;   
  $botoes=($ticket) ? $botoes."<button class='nav' type='submit'><icob>&#x1f5f9;</icob></button>\n" : $botoes ;
  $botoes=($paravolta) ? $botoes."<button class='nav' type='button' onclick='history.go(-1)'><icob>&#x2397;</icob></button>\n" : $botoes ;
  $botoes=($paramenu)  ? $botoes."<button class='nav' type='button' onclick='history.go(-$menu)'><icob>&#x1f3e0;&#xfe0e;</icob></button>\n" : $botoes ;
  $botoes=($limpar)    ? $botoes."<button class='nav' type='reset'><icob>&#x2b6e;</icob></button>\n" : $botoes ;
  $botoes=($parasair)  ? $botoes."<button class='nav' type='button' onclick='history.go(-$sair)'><icob>&#x2348;</icob></button>\n" : $botoes ;
  
  # montando o icone da ação.
	if($icone!=""){
		$botoes="<button class='nav' type='submit'>".$icone."</button>\n".$botoes;
	}

 
  # printf("$paravolta,$paramenu,$parasair,$limpar,$acao -> ");
  printf("$botoes<br>\n");
/*        <icon>&#x1f7a5;</icon>          -  <u>Incluir</u> linhas na tabela &agrave; partir de campos de form.</td></tr>
          <icon>&#x1f589;</icon>          -  <u>Alterar</u> dados de uma linha escolhida da tabela.</td></tr>
          <icon>&#x1f7ac;</icon>          -  <u>Excluir</u> uma linha escolhida da tabela.</td></tr>
          <icon>&#x1f5f9;</icon>          -  Ticket ok! Confirma  ação.</td></tr>
          <icon>&#x1f50d;&#xfe0e;</icon>  -  <u>Consultar</u> detalha os dados de uma linha escolhida da tabela.</td></tr>
          <icom>&#x1f5a8;</icom>          -  <u>Listar</u> emite uma listagem dos dados de uma tabela com dados relacionados por chaves estrangeiras.
          <icon>&#x2b6e;</icon>           -  <u>Limpar</u> os campos do Formulário (se preciso)</td></tr>
          <icon>&#x2397;</icon>           -  <u>Voltar</u> uma tela na navegação das funcionalidades</td></tr>
          <icon>&#x1f3e0;&#xfe0e;</icon>  -  <u>Abertura - Entrada ou Home</u> (Esta página)</td></tr>
          <icon>&#x2348;</icon>           -  <u>Sair</u> do Sistema</td></tr>              */
}

function montamenu($tab,$tabname,$acao,$sair) 
{ # Função.....: montamenu
  # Descricao..: Emite as TAGs que montam o menu de navegação na div suoerior da tela do sistema. No arquivo .CSS são definidas os seletores de DIVS
  #              para a região superior da tela e 'dentro' desta para os botões que formam o menu.
  # Parametros.: Esta Funcao recebe os parametros:
  #              $acao: Texto para indicar qual CLASSE de SELETOR será referenciada no arquivo .CSS 
  #                     (externo e no mesmo diretório dos PAs) para as TAGs <DIV>
  #                     As ações disponíveis são: Abertura,Incluir, Consultar, Excluir, Alterar e Listar
  #              $sair: Variável que controle a quantidade de saltos executados entre as funcionalidades.
  #                       É usada para administrar a construção da barra de botões de navegação.
  # Autor......: JMH - Use! Mas fale quem fez!
  # Criação....: 2022-05-20
  # Atualização: 2022-05-20 - Desenvolvimento e teste da funcao.
  #              2022-05-20 - Alterei o codigo usando o link para um arquivo .CSS. DEPENDENDO do valor de $fundo, as
  #                           cores de fundo passar a depender de $acao (uma cor para cada ação ICAEL). No .CSS estão
  #                           especificados seletores para cada ação para a tela de abertura.
  #              2021-10-20 - Esta função estava definida em âmbito local para cada grupo de PAs de cada tabela. Parametrizei o nome da tabela
  #                           e coloquei esta nova função como 'sistêmica'.
  #--------------------------------------------------------------------------------------------------------------------------------------------------
  printf("<div class='$acao'>\n");
 
  printf(" <div class='menu'>\n");
  printf(" <form action='' method='POST'>\n");
  printf("<input type='hidden' name='sair' value='$sair'>\n");
  printf("&Aacuterea estudo/cursos:\n");
  printf("<button class='ins' type='submit' formaction='./areaestcursosincluir.php'><icom>&#x1f7a5;</icom></button>\n");
  printf("<button class='alt' type='submit' formaction='./areaestcursosalterar.php'><icom>&#x1f589;</icom></button>\n");
  printf("<button class='del' type='submit' formaction='./areaestcursosexcluir.php'><icom>&#x1f7ac;</icom></button>\n");
  printf("<button class='con' type='submit' formaction='./areaestcursosconsultar.php'><icom>&#x1f50d;&#xfe0e;</icom></button>\n");
  printf("<button class='lst' type='submit' formaction='./areaestcursoslistar.php'><icom>&#x1f5a8;</icom></button>\n");
  printf("<button class='nav' type='button' onclick='history.go(-$sair)'><icom>&#x2348;</icom></button>\n");
  printf(" </form>\n");
  printf("</div>\n");
  printf("<red>$acao</red><hr>\n");
  printf("</div>\n<br><br><br>\n");
}




?>