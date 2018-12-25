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

    public function actionView($id)
    {
        $id = Yii::$app->request->get('id');

        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $category = Category::findOne($id);
        $this->setMeta('Eshoper | ' . $category->name, $category->keywords, $category->description);

        return $this->render('view', compact('products', 'pages', 'category'));
    }
}