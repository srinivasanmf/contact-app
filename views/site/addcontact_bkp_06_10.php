	<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\depdrop\DepDrop;

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
				<?php  $countryArray = ArrayHelper::map($countryList,'code','name');
						?>
				<?= $form->field($model, 'country')->dropDownList($countryArray, ['id'=>'country','prompt' => ' -- Select Country --']); ?>
				<?php 
				echo $form->field($model, 'province')->widget(DepDrop::classname(), [
					'options'=>['id'=>'province'],
					'pluginOptions'=>[
					'depends'=>['country'], // the id for cat attribute
					'placeholder'=>'-- Select Province --',
					'url'=>Url::to(['site/provinces'])
					]
				]);?>
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
