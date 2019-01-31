<?php
/**
 * Core Pages (core-pages)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\page\AdminController
 * @var $model ommu\core\models\CorePages
 * @var $form app\components\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 16:08 WIB
 * @modified date 31 January 2019, 16:38 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\ActiveForm;
use yii\redactor\widgets\Redactor;
use ommu\core\models\CorePages;

$redactorOptions = [
	'imageManagerJson' => ['/redactor/upload/image-json'],
	'imageUpload' => ['/redactor/upload/image'],
	'fileUpload' => ['/redactor/upload/file'],
	'plugins' => ['clips', 'fontcolor','imagemanager']
];
?>

<div class="core-pages-form">

<?php $form = ActiveForm::begin([
	'options' => [
		'enctype' => 'multipart/form-data',
	],
	'enableClientValidation' => false,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php echo $form->field($model, 'name_i', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12">{input}{error}</div>'])
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('name_i'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'desc_i', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12">{input}{error}</div>'])
	->textarea(['rows'=>6, 'cols'=>50])
	->widget(Redactor::className(), ['clientOptions' => $redactorOptions])
	->label($model->getAttributeLabel('desc_i'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'quote_i', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12">{input}{error}</div>'])
	->textarea(['rows'=>6, 'cols'=>50, 'maxlength'=>true])
	->label($model->getAttributeLabel('quote_i'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php $uploadPath = CorePages::getUploadPath(false);
$media = !$model->isNewRecord && $model->old_media != '' ? Html::img(join('/', [Url::Base(), $uploadPath, $model->old_media]), ['class'=>'mb-15', 'width'=>'100%']) : '';
echo $form->field($model, 'media', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><div>'.$media.'</div>{input}{error}</div>'])
	->fileInput()
	->label($model->getAttributeLabel('media'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php $mediaShow = CorePages::getMediaShow();
echo $form->field($model, 'media_show', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12">{input}{error}</div>'])
	->dropDownList($mediaShow, ['prompt'=>''])
	->label($model->getAttributeLabel('media_show'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php $mediaType = CorePages::getMediaType();
echo $form->field($model, 'media_type', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12">{input}{error}</div>'])
	->dropDownList($mediaType, ['prompt'=>''])
	->label($model->getAttributeLabel('media_type'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'publish', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12 checkbox">{input}{error}</div>'])
	->checkbox(['label'=>''])
	->label($model->getAttributeLabel('publish'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<div class="ln_solid"></div>
<div class="form-group">
	<div class="col-md-6 col-sm-9 col-xs-12 col-sm-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>

</div>