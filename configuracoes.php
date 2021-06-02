<?php

require_once './functions.php';
require_once './Database.php';
require_once "./header.html";

$errors = [];
$messages = [];
if (!empty(filter_input(INPUT_POST, 'uf_id'))) {
    $kwh = filter_input(INPUT_POST, "uf_kwh");
    if($kwh > 0) {
        $update = Database::update("ufs", ["kwh" => $kwh], filter_input(INPUT_POST, "uf_id"));
        if($update)
            $messages[] = "KWH atualizado com sucesso";
        else
            $errors[] = "Ocorreu um erro ao tentar salvar";
    } else {
        $errors[] = "KWH precisa ser maior que 0";
    }
} else if (!empty(filter_input(INPUT_POST, 'param_id'))) {
    $value = filter_input(INPUT_POST, "param_value");

    if($value >= 0) {
        $update = Database::update("parameters", ["value" => $value], filter_input(INPUT_POST, "param_id"));
        if($update)
            $messages[] = "Parâmetro atualizado com sucesso";
        else
            $errors[] = "Ocorreu um erro ao tentar salvar";
    } else {
        $errors[] = "Valor precisa ser maior ou igual a 0";
    }
}

$sqlUfs = "SELECT * FROM ufs ORDER BY name";
$sqlParams = "SELECT * FROM parameters ORDER BY name";

$ufs = Database::read($sqlUfs);
$params = Database::read($sqlParams);

?>

    <main class="bg-light p-5">
        <div class="container">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger mb-2">
                <?php foreach ($errors as $error): ?>
                <p class="m-0 p-0"><?php echo $error; ?></p>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($messages)): ?>
                <div class="alert alert-success mb-2">
                <?php foreach ($messages as $message): ?>
                <p class="m-0 p-0"><?php echo $message; ?></p>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Estados</div>
                        <div class="card-body">
                            <div class="list-group">
                                <?php foreach ($ufs as $key => $uf): ?>
                                    <div class="list-group-item">
                                        <form method="post" class="row">
                                            <div class="col-md-5 align-middle"><?php echo $uf['name']; ?></div>
                                            <div class="col-md-5">
                                                <input type="text" data-mask-reverse="true" data-mask="#0.00" class="form-control" name="uf_kwh" id="uf_kwh_<?php echo $key; ?>" value="<?php echo $uf['kwh']; ?>" required/>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-primary" name="uf_id" value="<?php echo $uf['id']; ?>">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Parâmtros</div>
                        <div class="card-body">
                            <div class="list-group">
                                <?php foreach ($params as $key => $param): ?>
                                    <div class="list-group-item">
                                        <form method="post" class="row">
                                            <div class="col-md-5 align-middle"><?php echo $param['name']; ?></div>
                                            <div class="col-md-5">
                                                <input type="text" data-mask-reverse="true" data-mask="#0.00" class="form-control" name="param_value" id="param_value_<?php echo $key; ?>" value="<?php echo $param['value']; ?>" required/>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-primary" name="param_id" value="<?php echo $param['id']; ?>">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
require_once "./footer.html";