<?php
/**
 * Ommu Themes (ommu-themes)
 * @var $this ThemeController
 * @var $model OmmuThemes
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-core
 *
 */
?>

<?php $form=$this->beginWidget('application.libraries.core.components.system.OActiveForm', array(
	'id'=>'ommu-themes-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">

	<fieldset>

		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'name', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<ul>
					<li><strong><?php echo $model->name;?></strong></li>
					<li><?php echo $model->getAttributeLabel('folder');?>: <?php echo $model->folder;?></li>
					<li><?php echo $model->getAttributeLabel('layout');?>: <?php echo $model->layout;?></li>
				</ul>
				
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'group_page', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->dropDownList($model, 'group_page', array(
					'public' => Yii::t('phrase', 'Public'),
					'admin' => Yii::t('phrase', 'Administrator'),
					'maintenance' => Yii::t('phrase', 'Offline (Coming Soon & Maintenance)'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'group_page'); ?>
			</div>
		</div>

		<div class="form-group row publish">
			<?php echo $form->labelEx($model,'default_theme', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->checkBox($model,'default_theme', array('class'=>'form-control')); ?>
				<?php echo $form->labelEx($model, 'default_theme'); ?>
				<?php echo $form->error($model,'default_theme'); ?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>

