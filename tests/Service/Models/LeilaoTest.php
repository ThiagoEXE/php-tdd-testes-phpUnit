<?php
namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{

    public function testLeilaoDeveReceberLances()
    {
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');

        $leilao = new Leilao('Fiat 147 0KM');
        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 2000));

        static::assertCount(2, $leilao->getLances());
        static::assertEquals(1000, $leilao->getLances()[0]->getValor());
        static::assertEquals(2000, $leilao->getLances()[1]->getValor());
    }

    public function geraLances(){
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');

        $leilaoCom2Lances = new Leilao('Fiat 147 0KM');
        $leilaoCom2Lances->recebeLance(new Lance($joao, 1000));
        $leilaoCom2Lances->recebeLance(new Lance($maria, 2000));

        $leilaoCom1Lance = new Leilao('Fusca 1970 0KM');
        $leilaoCom1Lance->recebeLance(new Lance($maria, 5000));

        return [
            [2, $leilaoCom2Lances, [1000,2000]],
        [1,$leilaoCom2Lances, [1000]]
    ];
    }
}