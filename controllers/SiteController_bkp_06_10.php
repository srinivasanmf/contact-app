<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Contacts;
use yii\helpers\Json;


class SiteController extends Controller
{	
	/*
	Loads contact app index page
	*/
	public function actionIndex()
	{
		$models = Contacts::find()->all();
		if($models == NULL)
			Yii::$app->session->setFlash('error', 'No contacts found.');
		return $this->render('index', array('models' => $models));
	}
	
	/*
	Method used to add / update the contacts
	*/
	public function actionAddcontact($id=NULL)
	{		
		if ($id == NULL)
			$model = new Contacts;
		else
			$model= Contacts::find()->where(['id' => $id])->one();
		if (isset($_POST['Contacts']))
		{			
			$model->load($_POST);
			if ($model->save())
			{
				Yii::$app->session->setFlash('success', 'Contact has been saved successfully.');
				$models = Contacts::find()->all();
				return $this->render('index', array('models' => $models));
			}
			else
				Yii::$app->session->setFlash('error', 'Contact could not be saved.');
		}
		$url = 'http://localhost/contact-app-mf/web/countries.json';
        $content = file_get_contents($url);
        $countryList = json_decode($content, true);
		return $this->render('addcontact', array('model' => $model,'countryList' => $countryList));
	}
	
	/*
	Method used to delete the contacts
	*/
	public function actionDelete($id=NULL)
	{
		$model= Contacts::find()->where(['id' => $id])->one();
		if ($model !== NULL && !$model->delete())
			Yii::$app->session->setFlash('error', 'Unable to delete Contact');
		$models = Contacts::find()->all();
		return $this->render('index', array('models' => $models));
	}
	
	/*
	Method used to get provinces for country
	*/
	public function actionProvinces() {
		$provincesList = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$country = $parents[0];		
				$url = 'http://localhost/contact-app-mf/web/provinces.json';
				$content = file_get_contents($url);
				$countryList = json_decode($content, true);		
				for($i=0; $i<sizeof($countryList); $i++){
					if($countryList[$i]['id'] == $country && isset($countryList[$i]['provinces'])){
						$provincesList = $countryList[$i]['provinces'];
						return Json::encode(['output'=>$provincesList]);
					}
				}
			}
		}
		$provincesList = [['id'=>'-', 'name'=>'-']];
		return Json::encode(['output'=>$provincesList, 'selected'=>'-']);
	}
}