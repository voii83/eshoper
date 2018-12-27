<?php

namespace app\controllers;

use app\components\Debug;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;

class CategoryController extends AppController
{
    public function actionIndex()
    {
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('Eshoper');
        return $this->render('index', compact('hits'));
    }

    public function actionView()
    {
        $id = Yii::$app->request->get('id');

        $category = Category::findOne($id);
        if (empty($category)) {
            throw new \yii\web\HttpException(404, 'Такой категории  нет');
        }

        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $this->setMeta('Eshoper | ' . $category->name, $category->keywords, $category->description);

        return $this->render('view', compact('products', 'pages', 'category'));
    }

    public function actionSearch()
    {
        $search = trim(Yii::$app->request->get('search'));
        $this->setMeta('Eshoper | Поиск: ' . $search);
        // Обрабатываем пустой запрос
        if (!$search) {
            return $this->render('search');
        }
        $query = Product::find()->where(['like', 'name', $search]);

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();


        return $this->render('search', compact('products', 'pages', 'search'));
    }
}