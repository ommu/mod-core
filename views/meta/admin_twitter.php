<?php
/**
 * Core Metas (core-meta)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\MetaController
 * @var $model ommu\core\models\CoreMeta
 * @var $form app\components\ActiveForm
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
use app\components\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Metas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Global Meta'), 'url' => Url::to(['update']), 'icon' => 'pencil'],
	['label' => Yii::t('app', 'Address'), 'url' => Url::to(['address']), 'icon' => 'pencil'],
	['label' => Yii::t('app', 'Google Owner Meta'), 'url' => Url::to(['google']), 'icon' => 'pencil'],
	['label' => Yii::t('app', 'Twitter Meta'), 'url' => Url::to(['twitter']), 'icon' => 'pencil'],
	['label' => Yii::t('app', 'Facebook Meta'), 'url' => Url::to(['facebook']), 'icon' => 'pencil'],
];

$js = <<<JS
	$('.field-twitter_card select[name="twitter_card"]').on('change', function() {
		var id = $(this).val();
		$('div.filter').slideUp();
		if(id == '3') {
			$('div.filter#photo').slideDown();
		} else if(id == '4') {
			$('div.filter#application').slideDown();
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

<?php echo $form->errorSummary($model);?>

<?php 
$setting = [
	1 => Yii::t('app', 'Enable'),
	0 => Yii::t('app', 'Disable'),
];
echo $form->field($model, 'twitter_on')
	->radioList($setting, ['class'=>'desc', 'separator' => '<br />'])
	->label($model->getAttributeLabel('twitter_on')); ?>

<?php 
$twitter_card = [
	1 => Yii::t('app', 'Summary Card'),
	2 => Yii::t('app', 'Summary Card with Large Image'),
	3 => Yii::t('app', 'Photo Card'),
	4 => Yii::t('app', 'App Card'),
	//5 => Yii::t('app', 'Gallery Card'),
	//6 => Yii::t('app', 'Player Card'),
	//7 => Yii::t('app', 'Player Card: Approval Guide'),
	//8 => Yii::t('app', 'Product Card'),
];
echo $form->field($model, 'twitter_card')
	->dropDownList($twitter_card)
	->label($model->getAttributeLabel('twitter_card')); ?>

<?php echo $form->field($model, 'twitter_site')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('twitter_site'))
	->hint(Yii::t('app', 'Your official site in twitter (.i.e. "@CareerCenterCodes, @OmmuPlatform")')); ?>

<?php echo $form->field($model, 'twitter_creator')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('twitter_creator'))
	->hint(Yii::t('app', 'Creator your site in twitter (.i.e. "@PutraSudaryanto, @Mba_Em")')); ?>

<div id="photo" class="form-group field-twitter_photo_size filter" <?php echo $model->twitter_card != 3 ? 'style="display: none;"' : '';?>>
	<?php echo $form->field($model, 'twitter_photo_size[i]', ['template' => '{label}', 'options' => ['tag' => null]])
		->label($model->getAttributeLabel('twitter_photo_size[i]'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>
	<div class="col-md-6 col-sm-9 col-xs-12 row">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<?php 
			if(!$model->isNewRecord && !$model->getErrors())
				$model->twitter_photo_size = unserialize($model->twitter_photo_size);
			echo $form->field($model, 'twitter_photo_size[width]', ['template' => '{input}{error}{hint}'])
				->textInput(['type'=>'number', 'min'=>1, 'maxlength'=>'3', 'placeholder'=>$model->getAttributeLabel('twitter_photo_size[width]')])
				->label($model->getAttributeLabel('twitter_photo_size[width]'))
				->hint(Yii::t('app', 'Providing width in px helps us more accurately preserve the aspect ratio of the image when resizing')); ?>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<?php echo $form->field($model, 'twitter_photo_size[height]', ['template' => '{input}{error}{hint}'])
				->textInput(['type'=>'number', 'min'=>1, 'maxlength'=>'3', 'placeholder'=>$model->getAttributeLabel('twitter_photo_size[height]')])
				->label($model->getAttributeLabel('twitter_photo_size[height]'))
				->hint(Yii::t('app', 'Providing height in px helps us more accurately preserve the aspect ratio of the image when resizing')); ?>
		</div>
	</div>
</div>

<?php echo $form->field($model, 'twitter_country')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('twitter_country'))
	->hint(Yii::t('app', 'If your application is not available in the US App Store, you must set this value to the two-letter country code for the App Store that contains your application.')); ?>

<div id="application" class="filter" <?php echo $model->twitter_card != 4 ? 'style="display: none;"' : '';?>>
	<div class="form-group">
		<?php echo $form->field($model, 'twitter_iphone[i]', ['template' => '{label}', 'options' => ['tag' => null]])
			->label($model->getAttributeLabel('twitter_iphone[i]'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>
		<div class="col-md-6 col-sm-9 col-xs-12">
			<div class="h5"><?php echo $model->getAttributeLabel('twitter_iphone[name]');?></div>
			<?php 
			if(!$model->isNewRecord && !$model->getErrors())
				$model->twitter_iphone = unserialize($model->twitter_iphone);
			echo $form->field($model, 'twitter_iphone[name]', ['template' => '{input}{error}{hint}'])
				->textInput(['maxlength' => 64])
				->label($model->getAttributeLabel('twitter_iphone[name]'))
				->hint(Yii::t('app', 'Name of your iPhone app')); ?>

			<div class="h5"><?php echo $model->getAttributeLabel('twitter_iphone[id]');?></div>
			<?php echo $form->field($model, 'twitter_iphone[id]', ['template' => '{input}{error}{hint}'])
				->textInput(['maxlength' => 32])
				->label($model->getAttributeLabel('twitter_iphone[id]'))
				->hint(Yii::t('app', 'String value, and should be the numeric representation of your app ID in the App Store (.i.e. "307234931")')); ?>
			
			<div class="h5"><?php echo $model->getAttributeLabel('twitter_iphone[url]');?></div>
			<?php echo $form->field($model, 'twitter_iphone[url]', ['template' => '{input}{error}{hint}'])
				->textInput(['maxlength' => false])
				->label($model->getAttributeLabel('twitter_iphone[url]'))
				->hint(Yii::t('app', 'Your app\'s custom URL scheme (you must include "://" after your scheme name)')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->field($model, 'twitter_ipad[i]', ['template' => '{label}', 'options' => ['tag' => null]])
			->label($model->getAttributeLabel('twitter_ipad[i]'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>
		<div class="col-md-6 col-sm-9 col-xs-12">
			<div class="h5"><?php echo $model->getAttributeLabel('twitter_ipad[name]');?></div>
			<?php 
			if(!$model->isNewRecord && !$model->getErrors())
				$model->twitter_ipad = unserialize($model->twitter_ipad);
			echo $form->field($model, 'twitter_ipad[name]', ['template' => '{input}{error}{hint}'])
				->textInput(['maxlength' => 64])
				->label($model->getAttributeLabel('twitter_ipad[name]'))
				->hint(Yii::t('app', 'Name of your iPad optimized app')); ?>

			<div class="h5"><?php echo $model->getAttributeLabel('twitter_ipad[id]');?></div>
			<?php echo $form->field($model, 'twitter_ipad[id]', ['template' => '{input}{error}{hint}'])
				->textInput(['maxlength' => 32])
				->label($model->getAttributeLabel('twitter_ipad[id]'))
				->hint(Yii::t('app', 'String value, should be the numeric representation of your app ID in the App Store (.i.e. “307234931”)')); ?>
			
			<div class="h5"><?php echo $model->getAttributeLabel('twitter_ipad[url]');?></div>
			<?php echo $form->field($model, 'twitter_ipad[url]', ['template' => '{input}{error}{hint}'])
				->textInput(['maxlength' => false])
				->label($model->getAttributeLabel('twitter_ipad[url]'))
				->hint(Yii::t('app', 'Your app\'s custom URL scheme (you must include "://" after your scheme name)')); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->field($model, 'twitter_googleplay[i]', ['template' => '{label}', 'options' => ['tag' => null]])
			->label($model->getAttributeLabel('twitter_googleplay[i]'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>
		<div class="col-md-6 col-sm-9 col-xs-12">
			<div class="h5"><?php echo $model->getAttributeLabel('twitter_googleplay[name]');?></div>
			<?php 
			if(!$model->isNewRecord && !$model->getErrors())
				$model->twitter_googleplay = unserialize($model->twitter_googleplay);
			echo $form->field($model, 'twitter_googleplay[name]', ['template' => '{input}{error}{hint}'])
				->textInput(['maxlength' => 64])
				->label($model->getAttributeLabel('twitter_googleplay[name]'))
				->hint(Yii::t('app', 'Name of your Android app')); ?>

			<div class="h5"><?php echo $model->getAttributeLabel('twitter_googleplay[id]');?></div>
			<?php echo $form->field($model, 'twitter_googleplay[id]', ['template' => '{input}{error}{hint}'])
				->textInput(['maxlength' => 32])
				->label($model->getAttributeLabel('twitter_googleplay[id]'))
				->hint(Yii::t('app', 'String value, and should be the numeric representation of your app ID in Google Play (.i.e. "co.ommu.nirwasita")')); ?>
			
			<div class="h5"><?php echo $model->getAttributeLabel('twitter_googleplay[url]');?></div>
			<?php echo $form->field($model, 'twitter_googleplay[url]', ['template' => '{input}{error}{hint}'])
				->textInput(['maxlength' => false])
				->label($model->getAttributeLabel('twitter_googleplay[url]'))
				->hint(Yii::t('app', 'Your app\'s custom URL scheme (.i.e. "http://play.google.com/store/apps/details?id=co.ommu.nirwasita")')); ?>
		</div>
	</div>
</div>

<div class="ln_solid"></div>
<div class="form-group">
	<div class="col-md-6 col-sm-9 col-xs-12 col-sm-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>