<?php
/**
 * Ommu Themes (ommu-themes)
 * @var $this ThemeController
 * @var $model OmmuThemes
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Themes'=>array('manage'),
		'Upload',
	);
?>

<?php $form=$this->beginWidget('application.libraries.core.components.system.OActiveForm', array(
	'id'=>'ommu-themes-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'on_post' => '',
	)
)); ?>
<div class="dialog-content">

	<fieldset>

		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo Yii::t('phrase', 'Theme File');?></label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo CHtml::fileField('theme_file', '', array('maxlength'=>128, 'class'=>'form-control')); ?>
				<?php echo Yii::app()->user->hasFlash('error') ? '<div class="errorMessage">'.Yii::app()->user->getFlash('error').'</div>' : ''?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton(Yii::t('phrase', 'Upload'), array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>
