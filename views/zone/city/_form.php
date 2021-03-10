<?php
/**
 * Core Zone Cities (core-zone-city)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\CityController
 * @var $model ommu\core\models\CoreZoneCity
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 14 September 2017, 22:22 WIB
 * @modified date 30 January 2019, 17:13 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
use ommu\core\models\CoreZoneProvince;
?>

<div class="core-zone-city-form">

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

<?php $province = CoreZoneProvince::getProvince();
echo $form->field($model, 'province_id')
	->dropDownList($province, ['prompt' => ''])
	->label($model->getAttributeLabel('province_id')); ?>

<?php echo $form->field($model, 'city_name')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('city_name')); ?>

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