<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

//cenário de teste
$leilao = new Leilao('Fiat 147 0KM');

$maria = new Usuario('Maria');
$joao = new Usuario('João');

$leilao->recebeLance(new Lance($joao,2000));
$leilao->recebeLance(new Lance($maria,2500));


$leiloeiro = new Avaliador();

//verifica o código a ser testado
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();

//Verifica se a saída é a esperada
$valorEsperado = 2500;

if($maiorValor == $valorEsperado){
    echo "TESTE OK";
}else{
    echo "TESTE FALHOU";
}
