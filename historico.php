<?php

require_once './functions.php';
require_once './Database.php';
require_once "./header.html";

$sql = "SELECT logs.*, ufs.abbreviation AS state FROM logs INNER JOIN ufs ON ufs.id = logs.uf ORDER BY logs.created_at DESC;";
$logs = Database::read($sql);

?>

    <main class="bg-light p-5">
        <div class="container">
            <table class="table-striped table table-sm">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Preço - Energia</th>
                    <th>Endereço</th>
                    <th>Cidade</th>
                    <th>Custo Gerador</th>
                    <th>Custo instalação</th>
                    <th>Quantidade de KWH mensal</th>
                    <th>Custo Aproximado do Gerador</th>
                    <th>Meses para recuperar Investimento</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo $log['name']; ?></td>
                    <td><?php echo $log['email']; ?></td>
                    <td><?php echo $log['phone']; ?></td>
                    <td>R$<?php echo number_format($log['price'], 2, ',', '.'); ?></td>
                    <td><?php echo $log['address']; ?></td>
                    <td><?php echo $log['city']; ?>/<?php echo $log['state']; ?></td>
                    <td>R$<?php echo number_format($log['energy_generator_price'], 2, ',', '.'); ?></td>
                    <td>R$<?php echo number_format($log['install_price'], 2, ',', '.'); ?></td>
                    <td><?php echo $log['kwh_month']; ?></td>
                    <td>R$<?php echo number_format($log['approximate_cost'], 2, ',', '.'); ?></td>
                    <td>R$<?php echo number_format($log['months_profit'], 2, ',', '.'); ?></td>
                    <td><?php echo implode('/', array_reverse(explode('-', explode(' ', $log['created_at'])[0]))) . " - " . explode(' ', $log['created_at'])[1]; ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

<?php
require_once "./footer.html";