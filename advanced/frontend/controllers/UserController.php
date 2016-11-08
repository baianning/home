<?php
namespace frontend\controllers;

use Yii;
use Illuminate\Support\Facades\Redirect;
use frontend\models\Draft;
use yii\web\Controller;
use app\models\home;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\Country;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Query;
use app\models\yan;

class UserController extends Controller
{
	/**
 * 登录
 */
		public function actionLogin()
		{
			function check_input($data)
			{
				$data = addslashes($data);
				//判断自动添加反斜杠是否开启
				if(get_magic_quotes_gpc()){
				//去除反斜杠
					$data = stripslashes($data);
					}
					//把'_'过滤掉
					$data = str_replace("_", "\_", $data);
					$data = str_replace("_", "\#", $data);
					$data = str_replace("_", "\!", $data);
					$data = str_replace("_", "\@", $data);
					$data = str_replace("_", "\$", $data);
					$data = str_replace("_", "\^", $data);
					$data = str_replace("_", "\&", $data);
					$data = str_replace("_", "\"", $data);
					$data = str_replace("_", "\！", $data);
					$data = str_replace("_", "\￥", $data);
					//把'%'过滤掉
					$data = str_replace("%", "\……", $data);
					//把'*'过滤掉
					$data = str_replace("*", "\*", $data);
					//回车转换
					$data = nl2br($data);
					//去掉前后空格
					$data = trim($data);
					//将HTML特殊字符转化为实体
					$data = htmlspecialchars($data);
					return $data;
				}
				$resquest=Yii::$app->request;
				if($resquest->isPost )
				{
					$data = $resquest->post();
					unset($data['_csrf']);
					$pwd = check_input($data['password']);
					$name = check_input($data['username']);
					$query = new Query();
					$res = $query->from("admin")->where(["a_name"=>$name])->one();
					if(!$res)
					{
					Yii::$app->session->addFlash('error','账号或密码错误');
					return $this->render("public/login");
				}
				else
				{
					if($res['a_pwd']!=$pwd)
				{
				//提示账号和密码错误
					Yii::$app->session->addFlash('error','账号或密码错误');
					return $this->render("public/login");
				}
				else
				{
					Yii::$app->session['name'] = $name;
					return $this->render("public/index",['name'=>$name]);
				}
				}
				}
				else
				{
					return $this->render("public/login");
				}
				}
				
				
				//---------------------------------------------推出--------------------------------------------------------------------//
				public  function  actionLogout()
				{
					$name = Yii::$app->session['name'];
					unset($name);
					if(empty($name)||(!isset($name)))
					{
					return $this->redirect("?r=user/login");
					}
					else
					{
					Yii::$app->session->addFlash('error','推出失败');
					return $this->redirect("?r=user/index");
			}
		}
	/**
	 * 登录
	 */
//	public function actionLogin()
//	{
//		return $this->render("public\login");
//	}
	/**
	 * 主页
	 */
//	public function actionIndex()
//	{
//		return $this->render("public\index");
//	}
	/**
	 * 房源
	*/
	public function actionHouse()
	{
		$this->layout='main';
		$data = home::find();//Field为model层
		$rs=$data->count();
		$pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>4]);    //实例化分页类,带上参数(总条数,每页显示条数)    
        $model = $data->offset($pages->offset)->orderBy('h_id asc')->limit($pages->limit)->all();
		return $this->render("public\house_list",['model'=>$model,'pages'=>$pages,'rs'=>$rs]);
	}
	/**
	 * 编辑
	*/
	public function actionEdit()
	{
		
		return $this->render("public\house_edit.html");
	}
	/**
	 * 进入加载
	 */
	public function actionIntroduce()
	{
		return $this->render("public\introduce");
	}
	/**
	 * 查询
	 */
	public function actionSearch()
	{
		$this->layout='main';
		$data = home::find();
		$huxing=$_POST["xing"];
		$tai=$_POST["zhuang"];
		$zhi=$_POST["wei"];
//		$rows = (new \yii\db\Query())
//		->select("*")
//		->from('home')
//		->andwhere(['like','model',$huxing])
//		->andwhere(['like','state',$tai])
//		->andwhere(['like','address',$zhi])
//		->all();
		$pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' =>4]);
		$model = $data->offset($pages->offset)
		->orderBy('h_id asc')
		->andwhere(['like','model',$huxing])
		->andwhere(['like','state',$tai])
		->andwhere(['like','address',$zhi])
		->limit($pages->limit)
		->all();
		return \yii\helpers\Json::encode($model);
		return $this->render("public\house_list",['pages'=>$pages]);

	}
	/**
	 * 删除
	 */
	public function actionDel()
	{
		$id=$_GET["id"];
		$db=\Yii::$app->db->createCommand();
		$res=$db->delete("home","h_id=:id",[':id'=>$id])->execute();
		if($res)
		{
			return $this->redirect("?r=user/house");
		}else
		{
			echo "失败";
		}
	}
	/**
	 * 修改查询
	 */
	public function actionUpda()
	{
		$id=$_GET["id"];
		$db=new\yii\db\Query;
		$res=$db->select('*')->from('home')->where(['h_id'=>$id])->one(); 
		var_dump($res);
	}
	/**
	 * 批量
	 */
	public function actionDels()
	{
		$request = Yii::$app->request->post();
        $a_ids='';
        foreach ($request as $v){
//            print_r($v);
            for ($i=0;$i<count($v);$i++){
                $a_ids.=$v[$i].",";
            }
        }
        $a_ids=trim($a_ids,",");
//        echo  $a_ids;
        $res=Yii::$app->db->createCommand()->delete("home","h_id in ($a_ids)")->execute();
        if($res){
            return $this->redirect("?r=user/house");
        }

	}
}
