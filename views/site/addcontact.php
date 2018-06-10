	<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = ' Add / Update Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
	<div class="row">
		<div class="col-lg-5">
			<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
				<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
				<?= $form->field($model, 'email') ?>
				<?php  
					$countryArray = ArrayHelper::map($countryList,'code','name');
					$provincesArray = ArrayHelper::map($provincesList,'code','name');
				?>
				<?= $form->field($model, 'country')->dropDownList($countryArray, 
					['id'=>'country',
					'prompt' => ' -- Select Country --',
					'onchange' => '$.post("index.php?r=site/provinces&id='.'"+$(this).val(), function(data){
						$("select#province").html(data);
					});'					
					]);
					
				?>
				<?= $form->field($model, 'province')->dropDownList($provincesArray, 
					['id'=>'province',
					'prompt' => ' -- Select Province --',					
					]);
				?>
				<?= $form->field($model, 'subject') ?>
				<?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
				<div class="form-group">
					<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
					<?= Html::a(Yii::t('app', 'Cancel'), Url::toRoute(['index']), ['class' => 'btn btn-default', 'name' => 'cancel-button']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
