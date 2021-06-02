<?php

function config($variable, $default = "")
{
    $config = include "./config.php";

    if (isset($config[$variable]))
        return $config[$variable];

    return $default;
}

function param($variable, $column = 'value')
{
    $param = Database::read("SELECT * FROM parameters WHERE name = :name", ["name" => $variable]);

    if (!isset($param[0]) || !isset($param[0][$column]))
        return "";

    return $param[0][$column];
}

function kwh_month($price, $uf)
{
    $uf = Database::read("SELECT kwh FROM ufs WHERE id = :id", ['id' => $uf]);
    $kwh = (float)$uf[0]["kwh"];

    $price = $price / $kwh;
    return $price <= 0 ? 0 : $price;
}

function approximate_cost($kwhMonth, $energyGeneratorPrice)
{
    $price = $kwhMonth * $energyGeneratorPrice;

    return $price <= 0 ? 0 : $price;
}

function months_profit($costGenerator, $energyPrice, $installPrice)
{
    $cost = (0 - $installPrice) / ($costGenerator - $energyPrice);

    return is_numeric($cost) && floor($cost) != $cost ? intval($cost +  1) : $cost;
}

function log_save($variables) {
    Database::insert("logs", $variables);
}
