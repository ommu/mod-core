<?php
/**
 * Core Zone Provinces (core-zone-province)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\ProvinceController
 * @var $model ommu\core\models\CoreZoneProvince
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 8 September 2017, 15:02 WIB
 * @modified date 30 January 2019, 17:13 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use app\components\widgets\ActiveForm;
use ommu\core\models\CoreZoneCountry;
?>

<div class="core-zone-province-form">

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

<?php $country = CoreZoneCountry::getCountry();
echo $form->field($model, 'country_id')
	->dropDownList($country, ['prompt'=>''])
	->label($model->getAttributeLabel('country_id')); ?>

<?php echo $form->field($model, 'province_name')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('province_name')); ?>

<?php echo $form->field($model, 'mfdonline')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('mfdonline')); ?>

<?php echo $form->field($model, 'checked')
	->checkbox()
	->label($model->getAttributeLabel('checked')); ?>

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