<?php
/**
 * Core Metas (core-meta)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\MetaController
 * @var $model ommu\core\models\CoreMeta
 * @var $form yii\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 24 April 2018, 14:11 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Metas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if(!$small) {
$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Global Meta'), 'url' => Url::to(['update']), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Address'), 'url' => Url::to(['address']), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Google Owner Meta'), 'url' => Url::to(['google']), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Twitter Meta'), 'url' => Url::to(['twitter']), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Facebook Meta'), 'url' => Url::to(['facebook']), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
];
}

$js = <<<JS
	$('.field-facebook_type select[name="facebook_type"]').on('change', function() {
		var id = $(this).val();
		$('div.filter').slideUp();
		if(id == '1') {
			$('div.filter#profile').slideDown();
		}
	});
JS;
	$this->registerJs($js, \app\components\View::POS_READY);
?>

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => false,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php 
$setting = [
	1 => Yii::t('app', 'Enable'),
	0 => Yii::t('app', 'Disable'),
];
echo $form->field($model, 'facebook_on')
	->radioList($setting)
	->label($model->getAttributeLabel('facebook_on')); ?>

<?php 
$facebook_type = [
	1 => Yii::t('app', 'Profile'),
	2 => Yii::t('app', 'Website'),
];
if($model->isNewRecord && !$model->getErrors())
	$model->facebook_type = 2;
echo $form->field($model, 'facebook_type')
	->dropDownList($facebook_type)
	->label($model->getAttributeLabel('facebook_type')); ?>

<div id="profile" class="filter mb-10" <?php echo $model->facebook_type != 1 ? 'style="display: none;"' : '';?>>
	<?php echo $form->field($model, 'facebook_profile_firstname')
		->textInput(['maxlength' => true])
		->label($model->getAttributeLabel('facebook_profile_firstname'))
		->hint(Yii::t('app', 'The first name of the person that this profile represents')); ?>

	<?php echo $form->field($model, 'facebook_profile_lastname')
		->textInput(['maxlength' => true])
		->label($model->getAttributeLabel('facebook_profile_lastname'))
		->hint(Yii::t('app', 'The last name of the person that this profile represents')); ?>

	<?php echo $form->field($model, 'facebook_profile_username',)
		->textInput(['maxlength' => true])
		->label($model->getAttributeLabel('facebook_profile_username'))
		->hint(Yii::t('app', 'A username for the person that this profile represents (.i.e. "PutraSudaryanto")')); ?>
</div>

<?php echo $form->field($model, 'facebook_sitename')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('facebook_sitename'))
	->hint(Yii::t('app', 'The name of the web site upon which the object resides (.i.e. "Ommu Platform, Sudaryanto.ID")')); ?>

<?php echo $form->field($model, 'facebook_see_also')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('facebook_see_also'))
	->hint(Yii::t('app', 'URLs of related resources (.i.e. "http://www.ommu.co")')); ?>

<?php echo $form->field($model, 'facebook_admins')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('facebook_admins'))
	->hint(Yii::t('app', 'Facebook IDs of the app\'s administrators (.i.e. "PutraSudaryanto")')); ?>

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>