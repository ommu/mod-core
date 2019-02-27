<?php
/**
 * Core Settings (core-settings)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\SettingController
 * @var $model ommu\core\models\CoreSettings
 * @var $form app\components\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 23 April 2018, 18:49 WIB
 * @modified date 23 April 2018, 18:49 WIB
 * @modified by Putra Sudaryanto <putra@sudaryanto.id>
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use app\components\ActiveForm;
?>

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => true,
	//'enableClientScript' => true,
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php echo $form->field($model, 'site_creation')
	->textInput(['type' => 'date'])
	->label($model->getAttributeLabel('site_creation')); ?>

<?php echo $form->field($model, 'site_dateformat')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('site_dateformat')); ?>

<?php echo $form->field($model, 'site_timeformat')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('site_timeformat')); ?>

<?php echo $form->field($model, 'license_email')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('license_email')); ?>

<?php echo $form->field($model, 'license_key')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('license_key')); ?>

<?php echo $form->field($model, 'ommu_version')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('ommu_version')); ?>

<div class="ln_solid"></div>
<div class="form-group">
	<div class="col-md-6 col-sm-9 col-xs-12 col-sm-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>