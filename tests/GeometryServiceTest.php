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

    public function testCalculateCircleArea() : void{

       self::bootKernel();
       $this->geoService = static::getContainer()->get(GeometryService::class);

       $circleArea = $this->geoService->calculateCircleArea(5);
       $this->assertEqualsWithDelta(78.53,$circleArea,0.1,"La surface d'un cercle de rayon 5 doit être égal à 78,54");
    }
    public function testCalculateRectangleArea() : void{

       self::bootKernel();
       $this->geoService = static::getContainer()->get(GeometryService::class);

       $rectangleArea = $this->geoService->calculateRectangleArea(5,3);
       $this->assertEquals(15,$rectangleArea,"La surface d'un rectangle de longueur 5 et de largeur 3 doit être égal à 15");
    }
    
    public function testCalculateTriangleArea() : void{
       
        self::bootKernel();
       $this->geoService = static::getContainer()->get(GeometryService::class);

       $triangleArea = $this->geoService->calculateTriangleArea(5,8);
       $this->assertEquals(20,$triangleArea,"La surface d'un triangle de base 5 et hauteur 8 doit être égal à 20");
    }
    public function testCalculateCubeVolume() : void{
       
        self::bootKernel();
       $this->geoService = static::getContainer()->get(GeometryService::class);

       $cubeVolume = $this->geoService->calculateCubeVolume(5);
       $this->assertEquals(125,$cubeVolume,"Le volume d'une cube de côté 5 doit être égal à 125");
    }

    
    public function testCalculateCylinderVolume() : void{

        self::bootKernel();
       $this->geoService = static::getContainer()->get(GeometryService::class);

       $cylinderVolume = $this->geoService->calculateCylinderVolume(5,6);
       $this->assertEqualsWithDelta(471.23,$cylinderVolume,0.1,"Le volume d'un cylindre de rayon 5 et hauteur 6 doit être égal à 471,23");
    }
    public function testCalculateConeVolume() : void{
        
        self::bootKernel();
       $this->geoService = static::getContainer()->get(GeometryService::class);

       $coneVolume = $this->geoService->calculateConeVolume(5,6);
       $this->assertEqualsWithDelta(157.08,$coneVolume,0.1,"Le volume d'un cône de rayon 5 et hauteur 6 doit être égal à 157");
    }
}
