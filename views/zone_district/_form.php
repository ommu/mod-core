<?php
/**
 * Ommu Zone Districts (ommu-zone-district)
 * @var $this ZonedistrictController
 * @var $model OmmuZoneDistrict
 * @var $form CActiveForm
 * version: 1.3.0
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-core
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.libraries.core.components.system.OActiveForm', array(
	'id'=>'ommu-zone-district-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">
	<fieldset>
		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'city_id', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'city_id',array('maxlength'=>11, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'city_id'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'district_name', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'district_name',array('maxlength'=>64, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'district_name'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'mfdonline', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'mfdonline',array('maxlength'=>7, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'mfdonline'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'checked', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->checkBox($model,'checked', array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'checked'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'publish', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->checkBox($model,'publish', array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'publish'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


