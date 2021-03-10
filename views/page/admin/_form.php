<?php
/**
 * Core Pages (core-pages)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\page\AdminController
 * @var $model ommu\core\models\CorePages
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 2 October 2017, 16:08 WIB
 * @modified date 31 January 2019, 16:38 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use ommu\core\models\CorePages;

$redactorOptions = [
	'imageManagerJson' => ['/redactor/upload/image-json'],
	'imageUpload' => ['/redactor/upload/image'],
	'fileUpload' => ['/redactor/upload/file'],
	'plugins' => ['clips', 'fontcolor', 'imagemanager']
];
?>

<div class="core-pages-form">

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

<?php echo $form->field($model, 'name_i')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('name_i')); ?>

<?php echo $form->field($model, 'desc_i')
	->textarea(['rows' => 6, 'cols' => 50])
	->widget(Redactor::className(), ['clientOptions' => $redactorOptions])
	->label($model->getAttributeLabel('desc_i')); ?>

<?php echo $form->field($model, 'quote_i')
	->textarea(['rows' => 6, 'cols' => 50, 'maxlength' => true])
	->label($model->getAttributeLabel('quote_i')); ?>

<?php $uploadPath = CorePages::getUploadPath(false);
$media = !$model->isNewRecord && $model->old_media != '' ? Html::img(Url::to(join('/', ['@webpublic', $uploadPath, $model->old_media])), ['alt' => $model->old_media, 'class' => 'd-block border border-width-3 mb-4']).$model->old_media.'<hr/>' : '';
echo $form->field($model, 'media', ['template' => '{label}{beginWrapper}<div>'.$media.'</div>{input}{error}{hint}{endWrapper}'])
	->fileInput()
	->label($model->getAttributeLabel('media')); ?>

<?php $mediaShow = CorePages::getMediaShow();
echo $form->field($model, 'media_show')
	->dropDownList($mediaShow, ['prompt' => ''])
	->label($model->getAttributeLabel('media_show')); ?>

<?php $mediaType = CorePages::getMediaType();
echo $form->field($model, 'media_type')
	->dropDownList($mediaType, ['prompt' => ''])
	->label($model->getAttributeLabel('media_type')); ?>

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