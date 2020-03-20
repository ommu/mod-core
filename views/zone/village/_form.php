<?php
/**
 * Core Zone Villages (core-zone-village)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\VillageController
 * @var $model ommu\core\models\CoreZoneVillage
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 16 September 2017, 17:35 WIB
 * @modified date 30 January 2019, 17:15 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
?>

<div class="core-zone-village-form">

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
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

<?php $district_id = $form->field($model, 'district_id', ['template' => '{input}', 'options' => ['tag' => null]])->hiddenInput();
echo $form->field($model, 'districtName', ['template' => '{label}{beginWrapper}{input}'.$district_id.'{error}{hint}{endWrapper}'])
	// ->textInput(['maxlength'=>true])
	->widget(AutoComplete::className(), [
		'options' => [
			'data-toggle' => 'tooltip', 'data-placement' => 'top',
			'class' => 'ui-autocomplete-input form-control'
		],
		'clientOptions' => [
			'source' => Url::to(['zone/district/suggest', 'extend'=>'district_name']),
			'minLength' => 2,
			'select' => new JsExpression("function(event, ui) {
				\$('.field-districtname #district_id').val(ui.item.id);
				\$('.field-districtname #districtname').val(ui.item.label);
				return false;
			}"),
		]
	])
	->label($model->getAttributeLabel('districtName')); ?>

<?php echo $form->field($model, 'village_name')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('village_name')); ?>

<?php echo $form->field($model, 'zipcode')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('zipcode')); ?>

<?php echo $form->field($model, 'mfdonline')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('mfdonline')); ?>

<?php if($model->isNewRecord && !$model->getErrors())
	$model->publish = 1;
echo $form->field($model, 'publish')
	->checkbox()
	->label($model->getAttributeLabel('publish')); ?>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>