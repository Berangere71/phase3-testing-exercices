<?php

namespace App\Tests;

use App\Services\GeometryService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Activité 1 : Testez la classe GeometryService
 * Cette exercice est simple et a pour but de vous familiariser avec l'écriture de tests unitaires pour des méthodes de calcul.
 * La classe GeometryService contient plusieurs méthodes qui calculent des aires et des volumes pour différentes formes géométriques.
 * Votre tâche est d'écrire des tests unitaires pour chacune de ces méthodes
 */
class GeometryServiceTest extends KernelTestCase
{
    private GeometryService $geoService;
    
    public function testCalculateSquareArea() : void
    {
        self::bootKernel();
        $this->geoService = static::getContainer()->get(GeometryService::class);

        $squareArea = $this->geoService->calculateSquareArea(5);
        $this->assertEquals(25,$squareArea,"La surface d'un carré de coté 5 doit être égal à 25");
    }

    // Remplissez les test restants :)

    // public function testCalculateCircleArea() : void{

    //     // To do...
    // }
    // public function testCalculateRectangleArea() : void{

    //     // To do...
    // }
    // public function testCalculateTriangleArea() : void{
    //     // To do...
    // }
    // public function testCalculateCubeVolume() : void{
    //     // To do...

    // }
    // public function testCalculateCylinderVolume() : void{
    //     // To do...
    // }
    // public function testCalculateConeVolume() : void{
    //     // To do...
    // }
}
