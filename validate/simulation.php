<?php

function simulationValidate() {
    $errors = [];
    $validations = [
        "name" => nameSimulationValidate(filter_input(INPUT_POST, 'name')),
        "email" => emailSimulationValidate(filter_input(INPUT_POST, 'email')),
        "phone" => phoneSimulationValidate(filter_input(INPUT_POST, 'phone')),
        "price" => priceSimulationValidate(filter_input(INPUT_POST, 'price')),
        "address" => addressSimulationValidate(filter_input(INPUT_POST, 'address')),
        "city" => citySimulationValidate(filter_input(INPUT_POST, 'city')),
        "uf" => ufSimulationValidate(filter_input(INPUT_POST, 'uf')),
    ];

    foreach($validations as $key => $validation) {
        if(!$validation['status'])
            $errors[$key] = $validation['message'];
    }

    return $errors;
}

function nameSimulationValidate($name) {
    if(empty($name))
        return ["status" => false, "message" => "Campo com preenchimento obrigatório"];
    if(strlen($name) < 3)
        return ["status" => false, "message" => "Preencha corretamente seu nome"];
    if(strlen($name) > 255)
        return ["status" => false, "message" => "Limite de caracteres excedidos (255)"];
    
    return ["status" => true];
}

function emailSimulationValidate($email) {
    if(empty($email))
        return ["status" => false, "message" => "Campo com preenchimento obrigatório"];
    if(strlen($email) < 3)
        return ["status" => false, "message" => "Preencha corretamente seu e-mail"];
    if(strlen($email) > 255)
        return ["status" => false, "message" => "Limite de caracteres excedidos (255)"];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        return ["status" => false, "message" => "E-mail inválido"];

    return ["status" => true];
}

function phoneSimulationValidate($phone) {
    $phone = preg_replace('/[^\d]/', '', $phone);
    if(empty($phone))
        return ["status" => false, "message" => "Campo com preenchimento obrigatório"];
    if(strlen($phone) < 10 || strlen($phone) > 11)
        return ["status" => false, "message" => "Preencha corretamente o telefone"];

    return ["status" => true];
}

function priceSimulationValidate($price) {
    $price = (float) (str_replace(",", ".", preg_replace('/[^0-9,]/', '', $price)));
    if(empty($price))
        return ["status" => false, "message" => "Campo com preenchimento obrigatório"];
    if($price < 0)
        return ["status" => false, "message" => "Preencha corretamente o valor"];
    if($price == 0)
        return ["status" => false, "message" => "O valor precisa ser maior que 0"];

    return ["status" => true];
}

function addressSimulationValidate($address) {
    if(empty($address))
        return ["status" => false, "message" => "Campo com preenchimento obrigatório"];
    if(strlen($address) < 3)
        return ["status" => false, "message" => "Preencha corretamente seu endereço"];
    if(strlen($address) > 255)
        return ["status" => false, "message" => "Limite de caracteres excedidos (255)"];

    return ["status" => true];
}

function citySimulationValidate($city) {
    if(empty($city))
        return ["status" => false, "message" => "Campo com preenchimento obrigatório"];
    if(strlen($city) < 3)
        return ["status" => false, "message" => "Preencha corretamente sua cidade"];
    if(strlen($city) > 255)
        return ["status" => false, "message" => "Limite de caracteres excedidos (255)"];

    return ["status" => true];
}

function ufSimulationValidate($uf) {
    if(empty($uf))
        return ["status" => false, "message" => "Campo com preenchimento obrigatório"];
    if(!is_numeric($uf))
        return ["status" => false, "message" => "Preencha corretamente o estado"];

    return ["status" => true];
}
