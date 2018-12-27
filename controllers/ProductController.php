<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController
{
    public function actionView()
    {
        $id = Yii::$app->request->get('id');

        // Ленивая загрузка
        $product = Product::findOne($id);

        // Жадная загрузка
        //$product = Product::find()->with('category')->where(['id' => $id])->limit(1)->one();

        if (empty($product)) {
            throw new \yii\web\HttpException(404, 'Такого товара не существует');
        }

        // Популярные товары
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('Eshoper | ' . $product->name, $product->keywords, $product->description);

        return $this->render('view', compact('product', 'hits'));
    }
}