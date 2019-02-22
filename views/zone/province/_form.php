<?php
/**
 * Core Zone Provinces (core-zone-province)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\ProvinceController
 * @var $model ommu\core\models\CoreZoneProvince
 * @var $form app\components\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 8 September 2017, 15:02 WIB
 * @modified date 30 January 2019, 17:13 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use app\components\ActiveForm;
use ommu\core\models\CoreZoneCountry;
?>

<div class="core-zone-province-form">

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
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
	->checkbox(['label'=>''])
	->label($model->getAttributeLabel('checked')); ?>

<?php echo $form->field($model, 'publish')
	->checkbox(['label'=>''])
	->label($model->getAttributeLabel('publish')); ?>

<div class="ln_solid"></div>
<div class="form-group row">
	<div class="col-md-6 col-sm-9 col-xs-12 offset-sm-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>

</div>