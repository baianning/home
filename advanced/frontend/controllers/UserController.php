<?php
<<<<<<< HEAD
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class UserController extends Controller{
    public function actionDel(){
        $request=Yii::$app->request;
        $id=$request->get("id");
        $res=Yii::$app->db->createCommand()->delete("yan","id=$id")->execute();
        if($res){
            $this->redirect("?r=User/show");
=======

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
>>>>>>> 6165ed145a9f3e8a25ea71f1adba58484ac74cf3
        }
    }
}