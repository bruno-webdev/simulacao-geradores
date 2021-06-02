<?php

require_once './functions.php';
require_once './Database.php';

$ufs = Database::read("SELECT * FROM ufs ORDER BY name");

$name = "";
$email = "";
$phone = "";
$price = "";
$address = "";
$city = "";
$uf = "";
$kwhMonth = "";
$approximateCost = "";
$energyGeneratorPrice = "";
$installPrice = "";
$monthsProfit = "";

$errors = [];

if(!empty(filter_input(INPUT_POST, 'simulate'))) {
    require_once './validate/simulation.php';
    $errors = simulationValidate();

    $name = filter_input(INPUT_POST, "name");
    $email = filter_input(INPUT_POST, "email");
    $phone = filter_input(INPUT_POST, "phone");
    $price = filter_input(INPUT_POST, "price");
    $address = filter_input(INPUT_POST, "address");
    $city = filter_input(INPUT_POST, "city");
    $uf = filter_input(INPUT_POST, "uf");

    $energyGeneratorPrice = param("custo_gerador");
    $installPrice = param("preco_instalacao");

    $kwhMonth = kwh_month($price, $uf);
    $approximateCost = approximate_cost($kwhMonth, $energyGeneratorPrice);
    $monthsProfit = months_profit($approximateCost, $price, $installPrice);

    $log = [
        "name" => $name,
        "email" => $email,
        "phone" => preg_replace('/[^\d]/', '', $phone),
        "price" => str_replace(",", ".", str_replace(".", "", $price)),
        "address" => $address,
        "city" => $city,
        "uf" => $uf,
        "energy_generator_price" => number_format($energyGeneratorPrice, 2, ".", ""),
        "install_price" => number_format($installPrice, 2, ".", ""),
        "kwh_month" => number_format($kwhMonth, 2, ".", ""),
        "approximate_cost" => number_format($approximateCost, 2, ".", ""),
        "months_profit" => str_replace("-", "", $monthsProfit),
    ];

    log_save($log);
}
require_once "./header.html";

?>

<main class="bg-light p-5">
    <div class="container">
        <div class="card">
            <div class="card-header">Simulador</div>
            <div class="card-body">
                <form action="./" method="post" class="row">
                    <div class="col-md-6">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                        <?php if(isset($errors['name'])): ?><div class="text-danger"><?php echo $errors['name']; ?></div><?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                        <?php if(isset($errors['email'])): ?><div class="text-danger"><?php echo $errors['email']; ?></div><?php endif; ?>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="phone">Telefone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
                        <?php if(isset($errors['phone'])): ?><div class="text-danger"><?php echo $errors['phone']; ?></div><?php endif; ?>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="price">Valor Mensal - Energia</label>
                        <div class="input-group">
                            <div class="input-group-text">R$</div>
                            <input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>">
                        </div>
                        <?php if(isset($errors['price'])): ?><div class="text-danger"><?php echo $errors['price']; ?></div><?php endif; ?>
                    </div>
                    <div class="col-5 mt-2">
                        <label for="address">Endereço</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>">
                        <?php if(isset($errors['address'])): ?><div class="text-danger"><?php echo $errors['address']; ?></div><?php endif; ?>
                    </div>
                    <div class="col-4 mt-2">
                        <label for="city">Cidade</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>">
                        <?php if(isset($errors['city'])): ?><div class="text-danger"><?php echo $errors['city']; ?></div><?php endif; ?>
                    </div>
                    <div class="col-3 mt-2">
                        <label for="uf">Estado</label>
                        <select class="form-select" id="uf" name="uf">
                            <option value="">Selecione um estado</option>
                            <?php foreach($ufs as $state): ?>
                                <option value="<?php echo $state['id']; ?>" <?php echo $uf == $state['id'] ? 'selected' : ''; ?>><?php echo $state['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if(isset($errors['uf'])): ?><div class="text-danger"><?php echo $errors['uf']; ?></div><?php endif; ?>
                    </div>
                    <div class="col-12 mt-2">
                        <button class="btn btn-primary" name="simulate" value="1">Enviar</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if(!empty(filter_input(INPUT_POST, 'simulate'))): ?>
            <div class="card mt-3">
                <div class="card-header">Resultado</div>
                <div class="card-body">
                    <p class="alert alert-success">Com base nas informações, será necessário <?php echo str_replace("-", "", $monthsProfit); ?> meses para ter o retorno do investimento</p>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="install_price">Valor da Instalação</label>
                            <input class="form-control" type="text" name="install_price" id="install_price" value="R$ <?php echo number_format($installPrice, 2, ',', '.'); ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="kwh_month">Quantidade de KWH Mensal</label>
                            <input class="form-control" type="text" name="kwh_month" id="kwh_month" value="<?php echo $kwhMonth; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="generator_cost">Custo do Gerador por KWH</label>
                            <input class="form-control" type="text" name="generator_cost" id="generator_cost" value="R$ <?php echo number_format($energyGeneratorPrice, 2, ',', '.'); ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="approximate_cost">Custo aprox. do Gerador</label>
                            <input class="form-control" type="text" name="approximate_cost" id="approximate_cost" value="R$ <?php echo number_format($approximateCost, 2, ',', '.'); ?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
require_once "./footer.html";