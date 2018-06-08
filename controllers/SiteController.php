<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Contacts;

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
		return $this->render('addcontact', array('model' => $model));
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
}