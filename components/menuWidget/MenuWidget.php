<?php

namespace app\components\menuWidget;

use Yii;
use app\models\Category;
use yii\base\Widget;

class MenuWidget extends Widget
{
    public $tpl;
    public $data;
    public $tree;
    public $menuHtml;
    public $model;

    public function init()
    {
        parent::init();

        switch ($this->tpl) {
            case 'menu' :
                $this->tpl .= '.php';
                break;
            case  'select' :
                $this->tpl .= '.php';
                break;
            default :
                $this->tpl = 'menu.php';
                break;
        }
    }

    public function run()
    {
        // get cache
        if ($this->tpl == 'menu.php') {
            $menuAccordion = Yii::$app->cache->get('menuAccordion');
            if ($menuAccordion) return $menuAccordion;
        }

        $this->data = Category::find()->indexBy('id')->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);

        //set cache
        if ($this->tpl == 'menu.php') {
            Yii::$app->cache->set('menuAccordion', $this->menuHtml, 60);
        }

        return $this->menuHtml;
    }

    protected function getTree()
    {
        $tree = [];
        foreach ($this->data as $id=>&$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            }
            else {
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category, $tab);
        }
        return $str;
    }

    protected function catToTemplate($category, $tab)
    {
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }
}