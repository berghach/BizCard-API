<?php

class Viecule {
    public $speed;
    public function timing($distance){
        return $distance/$this->speed ;
    }
}

class Car extends Viecule{
    public $speed = 5;
}

class Bike extends Viecule{
    public $speed = 2;
}

$distance = 40;

$car = new Car;
$bike = new Bike;

$carTiming = $car->timing($distance);
$bikeTiming = $bike->timing($distance);