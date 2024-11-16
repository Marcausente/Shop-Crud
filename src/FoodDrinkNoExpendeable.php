<?php

class FoodDrinkNoExpendeable
{
    public $name;
    public $category;
    public $price;
    public $is_perishable;
    public $expiration_date;

    public function __construct($name, $category, $price, $is_perishable, $expiration_date){
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->is_perishable = $is_perishable;
        $this->expiration_date = $expiration_date;
    }

    public function saveToDatabase($conn){
        $insertarDatos = $conn->prepare("INSERT INTO FoodDrinkNoExpendeable (name, category, price, is_perishable, expiration_date) VALUES (?, ?, ?, ?, ?)");
        $insertarDatos->bind_param("ssdis", $this->name, $this->category, $this->price, $this->is_perishable, $this->expiration_date); //s son strings, d decimales, i inta
        return $insertarDatos->execute();
    }
}