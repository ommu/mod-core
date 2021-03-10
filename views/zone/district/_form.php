<?php
/**
 * Core Zone Districts (core-zone-district)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\DistrictController
 * @var $model ommu\core\models\CoreZoneDistrict
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 15 September 2017, 10:26 WIB
 * @modified date 30 January 2019, 17:14 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
?>

<div class="core-zone-district-form">

<?php $form = ActiveForm::begin([
	'options' => ['class' => 'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
	'fieldConfig' => [
		'errorOptions' => [
			'encode' => false,
		],
	],
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php $city_id = $form->field($model, 'city_id', ['template' => '{input}', 'options' => ['tag' => null]])->hiddenInput();
echo $form->field($model, 'cityName', ['template' => '{label}{beginWrapper}{input}'.$city_id.'{error}{hint}{endWrapper}'])
	// ->textInput(['maxlength' => true])
	->widget(AutoComplete::className(), [
		'options' => [
			'data-toggle' => 'tooltip', 'data-placement' => 'top',
			'class' => 'ui-autocomplete-input form-control'
		],
		'clientOptions' => [
			'source' => Url::to(['zone/city/suggest', 'extend' => 'city_name']),
			'minLength' => 2,
			'select' => new JsExpression("function(event, ui) {
				\$('.field-cityname #city_id').val(ui.item.id);
				\$('.field-cityname #cityname').val(ui.item.label);
				return false;
			}"),
		]
	])
	->label($model->getAttributeLabel('cityName')); ?>

<?php echo $form->field($model, 'district_name')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('district_name')); ?>

<?php echo $form->field($model, 'mfdonline')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('mfdonline')); ?>

<?php echo $form->field($model, 'checked')
	->checkbox()
	->label($model->getAttributeLabel('checked')); ?>

<?php 
if ($model->isNewRecord && !$model->getErrors()) {
    $model->publish = 1;
}
echo $form->field($model, 'publish')
	->checkbox()
	->label($model->getAttributeLabel('publish')); ?>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>