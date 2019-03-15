<?php
/**
 * Core Languages (core-languages)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\LanguageController
 * @var $model ommu\core\models\CoreLanguages
 * @var $form app\components\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 08:40 WIB
 * @modified date 23 April 2018, 14:05 WIB
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

<?php echo $form->field($model, 'name')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('name')); ?>

<?php echo $form->field($model, 'code')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('code')); ?>

<?php echo $form->field($model, 'actived')
	->checkbox()
	->label($model->getAttributeLabel('actived')); ?>

<?php echo $form->field($model, 'default')
	->checkbox()
	->label($model->getAttributeLabel('default')); ?>

<div class="ln_solid"></div>
<div class="form-group row">
	<div class="col-md-6 col-sm-9 col-xs-12 col-12 col-sm-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>