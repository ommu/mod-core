<?php
/**
 * Core Metas (core-meta)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\MetaController
 * @var $model ommu\core\models\CoreMeta
 * @var $form app\components\widgets\ActiveForm
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
use ommu\core\models\CoreMeta;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Metas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Global Meta'), 'url' => Url::to(['update']), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Address'), 'url' => Url::to(['address']), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Google Owner Meta'), 'url' => Url::to(['google']), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Twitter Meta'), 'url' => Url::to(['twitter']), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Facebook Meta'), 'url' => Url::to(['facebook']), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
];
?>

<?php $form = ActiveForm::begin([
	'options' => [
		'class' => 'form-horizontal form-label-left',
		'enctype' => 'multipart/form-data',
	],
	'enableClientValidation' => false,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
	'fieldConfig' => [
		'errorOptions' => [
			'encode' => false,
		],
	],
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php $metaImage = !$model->isNewRecord && $model->old_meta_image_i != '' ? Html::img(Url::to(join('/', ['@webpublic', CoreMeta::getUploadPath(false), $model->old_meta_image_i])), ['alt'=>$model->old_meta_image_i, 'class'=>'mb-3']) : '';
echo $form->field($model, 'meta_image', ['template'=> '{label}{beginWrapper}<div>'.$metaImage.'</div>{input}{error}{hint}{endWrapper}'])
	->fileInput()
	->label($model->getAttributeLabel('meta_image')); ?>

<?php echo $form->field($model, 'meta_image_alt')
	->textInput()
	->label($model->getAttributeLabel('meta_image_alt')); ?>

<?php 
$setting = [
	1 => Yii::t('app', 'Enable'),
	0 => Yii::t('app', 'Disable'),
];
echo $form->field($model, 'office_on')
	->radioList($setting)
	->label($model->getAttributeLabel('office_on')); ?>
	
<?php echo $form->field($model, 'google_on')
	->radioList($setting)
	->label($model->getAttributeLabel('google_on')); ?>

<?php echo $form->field($model, 'twitter_on')
	->radioList($setting)
	->label($model->getAttributeLabel('twitter_on')); ?>

<?php echo $form->field($model, 'facebook_on')
	->radioList($setting)
	->label($model->getAttributeLabel('facebook_on')); ?>

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>