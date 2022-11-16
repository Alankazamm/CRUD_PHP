<?php
#####################################################################################################################################################
# Programa.: medicos (medicos.php)
# Descrição: Inclui a execução dos arquivos externos ("../../funcoes/toolskit1.php" e "./medicosfuncoes.php"), identifica valor de variável
#            de controle de saltos entre aplicativos ($sair). Executa funções externas e exibe mensagem de orientação do uso do sistema.
# Ojetivo..: Funcionalidade "Abertura" do Sistema de Gerenciamento de Dados na tabela medicos.
# Autor....: JMH
# Criação..: 2021-05-19
# Revisão..: 2021-05-19 - Primeira escrita e montagem da estrutura geral.
#            2021-10-02 - Refinamos a mensagem de orientação sobre o uso do sistema.
#####################################################################################################################################################
# Referenciando o arquivo catalogo.php

# Referenciando o arquivo medicosfuncoes.php
require_once("./areaestcursosfuncoes.php");	
require_once("../../funcoes/toolsbag.php");
# Determinando o valor de $sair.
global $sair;
global $menu;
$sair=1;
# monstrando o valor de $sair em cada execução
# printf("$sair<br>\n");
iniciapagina(TRUE,"Area de Estudo dos Curso","areaestcursos","Abertura");

montamenu("Area de Estudo dos Curso","areaestcursos","Abertura",$sair);
printf("<p>O site foi desenvolvido por Alan Bruno Silva de Jesus, RA: 0210481913021.</p><br>\n");
printf("Este sistema faz o Gerenciamento de dados da Tabela 'Area de estudo/curso'.<br>\n");
printf("O menu apresentado acima indica as funcionalidades do sistema.<br><br>\n");
printf("Em cada tela do sistema são apresentados acessos para:<br>\n");

/*printf("Limpar - <icon>&#x2b6e;</icon><br>
        'X' de excluir - <icon>&#x1f5f7;</icon><br>
        Pasta Abrindo - <icon>&#x1f5c1;</icon><br>
        Disquete - <icon>&#x1f5aa;</icon><br>
        Seta para direita 1 - <icon>&#x1f782;</icon><br>
        Seta para esquerda 1 - <icon>&#x1f780;</icon><br>
        Seta para direita 2 - <icon>&#x2b8a;</icon><br>
        Seta para esquerda 2 - <icon>&#x2b88;</icon><br>");
*/
printf("<ul>\n");
printf(" <li><u>Ação</u> de completar a funcionalidade escolhida.
          <table>
          <tr><td><icon>&#x1f7a5;</icon></td><td>-</td><td><u>Incluir</u> linhas na tabela &agrave; partir de campos de form.</td></tr>
          <tr><td><icon>&#x1f589;</icon></td><td>-</td><td><u>Alterar</u> dados de uma linha escolhida da tabela.</td></tr>
          <tr><td><icon>&#x1f7ac;</icon></td><td>-</td><td><u>Excluir</u> uma linha escolhida da tabela.</td></tr>
          <tr><td><icon>&#x1f5f9;</icon></td><td>-</td><td>Ticket ok! Confirma  ação.</td></tr>
          <tr><td><icon>&#x1f50d;&#xfe0e;</icon></td><td>-</td><td><u>Consultar</u> detalha os dados de uma linha escolhida da tabela.</td></tr>
          <tr><td><icon>&#x2b6e;</icon></td><td>-</td><td><u>Limpar</u> os campos do Formulário (se preciso)</td></tr>
          <tr><td><icon>&#x2397;</icon></td><td>-</td><td><u>Voltar</u> uma tela na navegação das funcionalidades</td></tr>
          <tr><td><icon>&#x1f3e0;&#xfe0e;</icon></td><td>-</td><td><u>Abertura - Entrada ou Home</u> (Esta página)</td></tr>
          <tr><td><icon>&#x2348;</icon></td><td>-</td><td><u>Sair</u> do Sistema</td></tr>
          </table>
         </li>\n");
printf("</ul><br>\n");
 botoes('',FALSE,FALSE,FALSE,FALSE,TRUE);
# botoes($acao,$clear,$back,$menu,$sair)
# printf("<button class='nav' type='button' onclick='history.go(-$sair)'><icon>&#x2348;</icon></button>\n");
terminapagina("areaestcursos","Area de Estudo dos Curso","areaestcursos.php");
?>
