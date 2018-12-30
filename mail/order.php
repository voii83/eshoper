<?php
?>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Фото</th>
            <th>Наименование</th>
            <th>Кол-во</th>
            <th>Цена</th>
            <th>Сумма</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($session['cart'] as $id => $item): ?>
            <tr>
                <td><?= \yii\helpers\Html::img("@web/images/home/{$item['img']}", ['alt' => $item['name'], 'height' => 50]) ?></td>
                <td><?= $item['name'] ?></td>
                <td><?= $item['qty'] ?></td>
                <td><?= $item['price'] ?></td>
                <td><?= $item['price'] * $item['qty'] ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="4">Итого:</td>
            <td><?= $session['cart.qty'] ?></td>
        </tr>
        <tr>
            <td colspan="4">На сумму:</td>
            <td><?= $session['cart.sum'] ?></td>
        </tr>
        </tbody>
    </table>
</div>

