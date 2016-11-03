<?php

namespace frontend\controllers;
use yii\web\Controller;
use Yii;
class UserController extends  Controller
{
    public  function actionIndex()
    {
       return  $this->render("index");
    }
    public  function  actionAdd()
    {
        $request=Yii::$app->request;
        if($request->isPost)
        {
            $data = $request->post();
            unset($data['_csrf']);
            $res=Yii::$app->db->createCommand()->insert('yan',$data)->execute();
            if($res)
            {
                $this->redirect("?r=user/show");
            }
            else
            {
                echo "<a href='?r=user/index'>数据添加失败</a>";
            }
        }
        else
        {
            return $this->render('index');
        }
    }
}