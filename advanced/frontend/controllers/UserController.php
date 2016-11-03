<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Draft;
use yii\web\Controller;
use app\models\yan;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\Country;
use yii\db\ActiveRecord;
use yii\db\Connection;

class UserController extends Controller
{
	public function actionIndex()
	{
		return $this->render("index");
	}
	public function actionAdd()
	{
		$res=\Yii::$app->request->post();
		unset($res["_csrf"]);
		$db=\Yii::$app->db->createCommand(); 
		$data=$db->insert('yan',$res)->execute();
		if($data)
		{
			$this->redirect(array("add/show"));
		}else
		{
			echo 0;
		}
	}
	public function actionShow()
	{
		$this->layout='main';
        $data = yan::find();//Field为model层
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>2]);    //实例化分页类,带上参数(总条数,每页显示条数)    
        $model = $data->offset($pages->offset)->orderBy('id asc')->limit($pages->limit)->all();
        return $this->render('show',['model' => $model,'pages' => $pages,]);
		
	}
}
