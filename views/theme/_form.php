<?php
/**
 * Ommu Themes (ommu-themes)
 * @var $this ThemeController
 * @var $model OmmuThemes
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */
?>

<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
	'id'=>'ommu-themes-form',
	'enableAjaxValidation'=>true,
)); ?>
<div class="dialog-content">

	<fieldset>

		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'name', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-9 col-md-9 col-sm-12">
				<ul>
					<li><strong><?php echo $model->name;?></strong></li>
					<?php if($model->group_page == 'admin' && $model->folder == 'ommu') {
						$group_page = array(
							'public' => Yii::t('phrase', 'Public'),
							'admin' => Yii::t('phrase', 'Administrator'),
							'maintenance' => Yii::t('phrase', 'Offline (Coming Soon & Maintenance)'),
						);?>
					<li><?php echo $model->getAttributeLabel('group_page');?>: <?php echo $group_page[$model->group_page];?></li>
					<?php }?>
					<li><?php echo $model->getAttributeLabel('folder');?>: <?php echo $model->folder;?></li>
					<li><?php echo $model->getAttributeLabel('layout');?>: <?php echo $model->layout;?></li>
				</ul>
				
			</div>
		</div>

		<?php if(!($model->group_page == 'admin' && $model->folder == 'ommu')) {?>
			<div class="form-group row">
				<?php echo $form->labelEx($model,'group_page', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-9 col-md-9 col-sm-12">
					<?php echo $form->dropDownList($model, 'group_page', array(
						'public' => Yii::t('phrase', 'Public'),
						'admin' => Yii::t('phrase', 'Administrator'),
						'maintenance' => Yii::t('phrase', 'Offline (Coming Soon & Maintenance)'),
					), array('class'=>'form-control')); ?>
					<?php echo $form->error($model,'group_page'); ?>
				</div>
			</div>
		<?php }?>

		<?php 
		$config = $theme['config'];
		if(!$model->getErrors())
			$model->config = unserialize($model->config);
		echo $this->renderPartial('_config_field', array(
			'form'=>$form,
			'model'=>$model,
			'config'=>$config,
			'parent'=>false,
		));?>

		<div class="form-group row publish">
			<?php echo $form->labelEx($model,'default_theme', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-9 col-md-9 col-sm-12">
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

