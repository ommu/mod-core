<?php
/**
 * Ommu Walls (ommu-walls)
 * @var $this WallController
 * @var $model OmmuWalls
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2015 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */
?>

<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
	'id'=>'ommu-walls-form',
	'enableAjaxValidation'=>true,
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<div class="form-group row publish">
		<?php echo $form->labelEx($model,'publish', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->checkBox($model,'publish', array('class'=>'form-control')); ?>
			<?php echo $form->labelEx($model, 'publish'); ?>
			<?php echo $form->error($model,'publish'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'user_id', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'user_id', array('size'=>11,'maxlength'=>11, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'user_id'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'wall_media', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textArea($model,'wall_media', array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'wall_media'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'wall_status', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textArea($model,'wall_status', array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'wall_status'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'comments', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'comments', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'comments'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'likes', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'likes', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'likes'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'creation_date', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'creation_date', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'creation_date'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'modified_date', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'modified_date', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'modified_date'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row submit">
		<label class="col-form-label col-lg-3 col-md-3 col-sm-12">&nbsp;</label>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php /*
<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') , array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
*/?>
<?php $this->endWidget(); ?>


