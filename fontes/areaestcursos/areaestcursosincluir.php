<?php
#################################################################################################################################
# Programa.: medicos (medicosincluir.php)
# Objetivo.: Funcionalidade "Incluir" do Sistema de Gerenciamento de Dados na tabela medicos.
# Descrição: Carrega as variáveis de controle do ambiente ($bloco).
#            Referencia o catalogo de funções ("../../funcoes/catalogo.php"). Referencia as funções ("./medicosfuncoes.php").
#            Executa funções externas iniciapagina() e terminapagina() e a função externa da tabela montamenu().  
#            Em um Switch-Case, no bloco 1, monta um form para entrada de dados e no bloco 2 faz o tratamento da transação.
# Autor....: JMH
# Criação..: 2022-05-27
# Revisão..: 2022-05-27 - Primeira escrita: Estruturação e cópia de segmentos de códigos dos programas de alteração para edição
#                         dos comandos para tratar a inclusão
#################################################################################################################################
# Referenciando o catalogo de funções (lembrete: está no diretório 'ao lado' de fontes
require_once("../../funcoes/toolsbag.php");; # A conexão com o BD já estabelecida.
# Referenciando o arquivo de funçoes de gerenciamento de médicos (medicosfuncoes.php)
require_once("./areaestcursosfuncoes.php");
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : '1' ;
# Na primeira 'execução' ou 'passada' o valor de $bloco vai ser '1'
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
iniciapagina(TRUE,"&Aacuterea estudo/cursos","areaestcursos","Incluir");
montamenu("&Aacuterea estudo/cursos","areaestcursos","Incluir",$sair);
# Bloco de controle de execução recursiva ($bloco)
switch (TRUE)
{
  case ( $bloco==1 ):
  { # Montagem do Formulário para entrada dos dados do médico a ser incluído na tabela
    printf("<form action='areaestcursosincluir.php' method='POST'>\n");
    printf("<input type='hidden' name='bloco' value='2'>\n");
    printf(" <input type='hidden' name='sair' value='$sair'>\n");
    # montando a tabela HTML com os campos do formulário
    printf("<table>\n");
    # estas linhas foram copiadas do PA-Alterar e retiramos o atributo VALUE=''
    # também editamos (retiramos) a variável $seleted.
    printf("<tr><td>C&oacute;digo:</td>              <td>O valor do C&oacute;digo ser&aacute; gerado pelo sistema</td></tr>\n");
   

   $cmdsql="SELECT idcurso, txnomecurso FROM cursos";
	$exccmd=mysqli_query($numconex,$cmdsql);

	printf("<tr><td>Curso:</td><td><select name='cursoid'>");
	while($reg=mysqli_fetch_array($exccmd)){

		$selected=( $reg['idcurso']==$reglido['cursoid'] ) ? " SELECTED": "" ;
		printf("<option value='$reg[idcurso]'$selected>$reg[txnomecurso]-($reg[idcurso])</option>\n");
	}
    printf("</select>\n");
    printf("</td></tr>\n");
	
	
	
	
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
    printf("</form>\n");
    break;
  }
  case ( $bloco==2 ):
  { # Tratamento da Transação para incluão.
    # O comando SQL INSERT deve ser 'montado' dentro da transação.
    # printf("$cmdsql\n"); # deixe este comando sem comentario para 'ver' o comando SQL em tmepo de execução.
    $tentativa=TRUE;
    while ( $tentativa )
    {
      # Avisando o inicio:
      mysqli_query($numconex,"START TRANSACTION");
      # lendo o ultimo registro gravado ba tabela e pegando o próximo valor.
      # Reescrevemos o uso das duas funções de ambiente do PHP para montar um
      # ' _fetch_array de _query() '
      $valor=mysqli_fetch_array(mysqli_query($numconex,"SELECT MAX(idareaestudocurso )+1 AS vmaxid FROM areaestcursos"));
      $cp=$valor['vmaxid'];


      # montando o comando insert com a CP assumindo o valor $valor['vmaxid']
      $cmdsql="INSERT INTO areaestcursos (idareaestudocurso,cursoid,areaestudoid,dtcadareaestudocurso)
                      VALUES ('$cp',
                              '$_REQUEST[cursoid]',
                              '$_REQUEST[areaestudoid]',
                              '$_REQUEST[dtcadareaestudocurso]'
                              )";
     # printf("$cmdsql\n"); # deixe este comando sem comentario para 'ver' o comando SQL em tmepo de execução.
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
      printf("Inclusão feita com sucesso!\n");
      mostrarregistro("$cp");
    }
    else
    {
      printf("Erro! $mens<br>\n");
    }
    # Aqui vamos 'montar' a barra de botões de navegação - usando uma função sistêmica gravada no arquivo catalogo.php
    # botoes($paravolta,$paramenu,$limpar,$acao)
    botoes('',FALSE,TRUE,TRUE,FALSE,TRUE);
    break;
  }
}
terminapagina("&Aacuterea estudo/cursos","Incluir","areaestcursosincluir.php");
?>
