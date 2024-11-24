<?php

class Store
{
    public $city;
    public $address;
    public $phone;
    public $email;
    public $openingTime;
    public $closingTime;

    public function __construct($city, $address, $phone, $email, $openingTime, $closingTime)
    {
        $this->city = $city;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
        $this->openingTime = $openingTime;
        $this->closingTime = $closingTime;
    }

    public function saveToDatabase($conn)
    {
        $insertarDatos = $conn->prepare(
            "INSERT INTO stores (city, address, phone, email, opening_time, closing_time) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        $insertarDatos->bind_param(
            "ssssss",
            $this->city,
            $this->address,
            $this->phone,
            $this->email,
            $this->openingTime,
            $this->closingTime
        );
        return $insertarDatos->execute();
    }
}
