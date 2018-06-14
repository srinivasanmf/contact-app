<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Contacts;

class ContactsController extends Controller
{	
	/*
	Method used to get contacts list with country / province names
	*/
	public function getContacts()
	{
		$models = Contacts::find()->all();
		$url = 'countries.json';
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
		return $models;
	}
}