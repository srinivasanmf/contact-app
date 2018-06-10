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
		$url = 'http://localhost/contact-app-mf/web/countries.json';
        $content = file_get_contents($url);
        $countryList = json_decode($content, true);
		foreach($models as $model){
			for($i=0; $i<sizeof($countryList); $i++){
				if($countryList[$i]['code'] == $model->country){
					$model->country = $countryList[$i]['name'];
					if(isset($countryList[$i]['provinces'])){
						$provincesList = $countryList[$i]['provinces'];
						for($j=0; $j<sizeof($provincesList); $j++){
							if($provincesList[$j]['code'] == $model->province)
								$model->province = $provincesList[$j]['name'];
						}
					}
				}
			}			
		}
		if($models == NULL)
			Yii::$app->session->setFlash('error', 'No contacts found.');
		return $this->render('index', array('models' => $models));
	}
	
	/*
	Method used to add / update the contacts
	*/
	public function actionAddcontact($id=NULL)
	{		
		$countryCode = 'US';
		$provincesList = [];
		if ($id == NULL){
			$model = new Contacts;
		}
		else{
			$model= Contacts::find()->where(['id' => $id])->one();
			$countryCode = $model->country;
		}
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
		$defaultProvince = '[{"code":"-","name":"-"}]';
		for($i=0; $i<sizeof($countryList); $i++){
			if($countryList[$i]['code'] == $countryCode && isset($countryList[$i]['provinces'])){
				$provincesList = $countryList[$i]['provinces'];
			}
		}	
		if($provincesList == NULL){
			$provincesList = json_decode($defaultProvince, true);
		}
		return $this->render('addcontact', array('model' => $model,'countryList' => $countryList, 'provincesList' => $provincesList));
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
	public function actionProvinces($id) {
		$provincesList = [];
		$url = 'http://localhost/contact-app-mf/web/countries.json';
		$content = file_get_contents($url);
		$countryList = json_decode($content, true);		
		for($i=0; $i<sizeof($countryList); $i++){
			if($countryList[$i]['code'] == $id && isset($countryList[$i]['provinces'])){
				$provincesList = $countryList[$i]['provinces'];
				for($j=0; $j<sizeof($provincesList); $j++){
					echo "<option value='".$provincesList[$j]['code']."'>".$provincesList[$j]['name']."</option>";
				}
				return;
			}
		}
		return "<option>-<option>";
	}
}