<?php

class store {
  public $city;
  public $address;
  public $phone;
  public $email;
  public $opening_time;
  public $closing_time;

  public function __construct($city, $address, $phone, $email, $opening_time, $closing_time)
  {
    $this->city = $city;
    $this->address = $address;
    $this->phone = $phone;
    $this->email = $email;
    $this->opening_time = $opening_time;
    $this->closing_time = $closing_time;
  }

    public function saveToDatabase($conn) {
        $insertar_datos = $conn->prepare("INSERT INTO stores (city, address, phone, email, opening_time, closing_time) VALUES (?, ?, ?, ?, ?, ?)");
        $insertar_datos->bind_param("ssssss", $this->city, $this->address, $this->phone, $this->email, $this->opening_time, $this->closing_time);
        return $insertar_datos->execute();
    }
}