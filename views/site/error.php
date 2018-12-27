<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error container">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <?php if ($exception->statusCode == 404) : ?>
    <h2>Ошибка 404</h2>
    <h3>Данная страница не существует</h3>
    <?php endif; ?>

</div>
