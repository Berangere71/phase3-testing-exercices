<?php
namespace App\Services;


class GeometryService{
    public function calculateSquareArea(float $side): float {
        return $side * $side;
    }

    public function calculateCircleArea(float $radius): float {
        return pi() * pow($radius, 2);
    }
    public function calculateRectangleArea(float $length, float $width): float {
        return $length * $width;
    }
    public function calculateTriangleArea(float $base, float $height): float {
        return 0.5 * $base * $height;
    }
    public function calculateCubeVolume(float $side): float {
        return pow($side, 3);
    }

    public function calculateCylinderVolume(float $radius, float $height): float {
        return pi() * pow($radius, 2) * $height;
    }
    public function calculateConeVolume(float $radius, float $height): float {
        return (1/3) * pi() * pow($radius, 2) * $height;
    }
}