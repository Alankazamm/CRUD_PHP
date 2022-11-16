<?php
#################################################################################################################################
# Programa.: catalogo de funções (catalogo.php)
# Objetivo.: Repositório de Funções do Sistema.
# Descrição: Define a existência de funções de uso GERAL dos PAs de Gerenciamento de dados das tabela de uma base de dados.
# Autor....: JMH
# Criação..: 2022-05-11
# Revisão..: 2022-05-04 - Primeira escrita e montagem da estrutura geral.
#            2022-05-11 - Escrevemos o cabeçalho deste arquivo (1h)
#               (1h)      Escrevemos a função de acesso ao banco de dados MariaDB.
#                         Alteramos alguns textos que eram exibidos nas funções iniciapagina() e terminapagina().
#################################################################################################################################
# função: segmento de código que pode ser referenciado e executado repetidas vezes
function iniciapagina($fundo,$tabnomepop,$tabnomeformal,$acao)
{ # emite as TAGs HTML que iniciam a página
  # Este comentário está dentro da função sem afetar o processamento

  printf("<html>\n");
  printf(" <head>\n");
  printf("  <title>$tabnomepop-$acao</title>\n");
  printf("  <link rel='stylesheet' href='./toolsbag.css'>\n");
  
  printf(" </head>\n");
  printf($fundo ? " <body class='$acao'>\n" : " <body>\n");
/*
  printf("<html>\n
          <head><meta charset='UTF-8'><title>1&ordf;P&aacute;gina</title>\n
          </head>\n
	  <body bgcolor='$cordefundo'>\n");
*/
}
function terminapagina($tab,$acao,$arqprg)
{ # aqui vai o corpo da função
  # emitindo as TAGs que 'fecham' a página
   printf("<hr>\n");
  printf("$tab - $acao | &copy; 2022-06-14 - NGC+FATEC-4ºADS | $arqprg\n");
  printf(" </body>\n");
  printf("</html>\n");
}
function conectamariadb($servidor,$usuario,$senha,$nomebase)
{
  ###################
  # Conectando o BD
  global $numconex;
  $numconex=mysqli_connect($servidor,$usuario,$senha,$nomebase);
  # Até a versão 6 do PHP a variável $numconex tinha que ser 'GLOBALIZADA', para que
  # fosse 'entendida' pelos programas que executam a função conectamariadb().
  
}
## Aqui termina os blocos que definem as funções GERAIS do sistema
#############################################################################################
# Executando a função que Conecta o BD MariaDB
conectamariadb("localhost","root","","ilp54020221");
?>