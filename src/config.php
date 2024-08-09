<?php

// Define o fuso horário para São Paulo
date_default_timezone_set('America/Sao_Paulo');

// Constantes para a conexão com o banco de dados
define('HOST', 'localhost');       // Servidor do banco de dados
define('DB_NAME', 'mydb');          // Nome do banco de dados
define('USER', 'root');             // Usuário do banco de dados
define('PASS', '');                 // Senha do banco de dados

// Nome do site
define('NOME_SITE', 'Zamplex');

// URLs base para ambientes de produção e desenvolvimento
define('ROUTER', 'zamplex');
define('URL_ONLINE', 'https://zambiank.com/' . ROUTER);  // URL para o ambiente de produção
define('URL_DESENVOLVIMENTO', 'http://localhost/' . ROUTER);  // URL para o ambiente de desenvolvimento

// Base do roteador
define('ROUTER_BASE', ROUTER . '/');  // Base para construir URLs internas