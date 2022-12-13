<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;
use Alura\Leilao\Service\Avaliador;
use PharIo\Manifest\Url;

class AvaliadorTest extends TestCase
{

    private $leiloeiro;

    public static function setUpBeforeClass():void{
        parent::setUpBeforeClass();
    }

    /*Antes de executar algum teste é executrado esse método que cria um leiloeiro, 
    o phpUnit ja entende que ele deve ser executado antes*/
    protected function setUp(): void
    {
        echo "Executando setUp" . PHP_EOL;

        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     *
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {



        //verifica o código a ser testado
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        //Verifica se a saída é a esperada
        self::assertEquals(2500, $maiorValor);
    }
    /**
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     *
     */
    public function testAvaliadorDeveEncontrarMenorValorDeLances(Leilao $leilao)
    {


        //verifica o código a ser testado
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

        //Verifica se a saída é a esperada
        self::assertEquals(1700, $menorValor);
    }
    /**
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     *
     */
    public function testAvaliadorDeveBuscarOsTresMaioresValores(Leilao $leilao)
    {

        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getMaioresLances();
        static::assertCount(3, $maiores);
        static::assertEquals(2500, $maiores[0]->getValor());
        static::assertEquals(2000, $maiores[1]->getValor());
        static::assertEquals(1700, $maiores[2]->getValor());
    }
    public function leilaoEmOrdemCrescente()
    {
        echo "Criando em ordem crescente" . PHP_EOL;

        $leilao = new Leilao('Fiat 147 0KM');
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            'ordem-crescente' => [$leilao]
        ];
    }
    public function leilaoEmOrdemDecrescente()
    {
        echo "Criando em ordem decrescente" . PHP_EOL;

        $leilao = new Leilao('Fiat 147 0KM');
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return [
            'ordem-decrescente' => [$leilao]
        ];
    }
    public function leilaoEmOrdemAleatoria()
    {
        echo "Criando em ordem aleatória" . PHP_EOL;

        $leilao = new Leilao('Fiat 147 0KM');
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($ana, 1700));

        return [
            'ordem-aleatoria' => [$leilao]
        ];
    }
    public function entregaLeiloes()
    {
        return [
            [$this->leilaoEmOrdemAleatoria()],
            [$this->leilaoEmOrdemCrescente()],
            [$this->leilaoEmOrdemDecrescente()],
        ];
    }
}
