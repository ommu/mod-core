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
 * @modified date 24 April 2018, 14:11 WIB
 * @modified by Putra Sudaryanto <putra@sudaryanto.id>
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\ActiveForm;
use ommu\core\models\CoreMeta;
?>

<?php $form = ActiveForm::begin([
	'options' => [
		'class' => 'form-horizontal form-label-left',
		'enctype' => 'multipart/form-data',
	],
	'enableClientValidation' => false,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php echo $form->field($model, 'office_hour')
	->textarea(['rows'=>2,'rows'=>6])
	->label($model->getAttributeLabel('office_hour')); ?>

<?php echo $form->field($model, 'office_hotline')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('office_hotline')); ?>

<?php echo $form->field($model, 'map_icons')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('map_icons')); ?>

<?php echo $form->field($model, 'map_icon_size')
	->textarea(['rows'=>2,'rows'=>6])
	->label($model->getAttributeLabel('map_icon_size')); ?>
	
<div class="ln_solid"></div>
<div class="form-group row">
	<div class="col-md-6 col-sm-9 col-xs-12 col-12 col-sm-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>