<?php

namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\FicheRepository;

class SerieControllerTest extends WebTestCase
{

    public function testFindByMonth()
    {
        self::bootKernel();
        $nb = count(self::$container->get(FicheRepository::class)->findByMonth(3));
        $this->assertEquals(10, $nb);
    }
    public function testFindByDate()
    {
        self::bootKernel();
        $nb = count(self::$container->get(FicheRepository::class)->findByDate("2020-03-13"));
        $this->assertEquals(10, $nb);
    }
}
