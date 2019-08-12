<?php
/**
 * Ommu Plugins (ommu-plugins)
 * @var $this ModuleController
 * @var $model OmmuPlugins
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Plugins'=>array('manage'),
		'Install',
	);
?>

<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
	'id'=>'projects-form',
	'enableAjaxValidation'=>true,
)); ?>
	<div class="dialog-content">
		<?php echo $model->install == 1 ? Yii::t('phrase', 'Are you sure you want to uninstall this item?') : Yii::t('phrase', 'Are you sure you want to install this item?')?>
	</div>
	<div class="dialog-submit">
		<?php echo CHtml::submitButton($title, array('onclick' => 'setEnableSave()')); ?>
		<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
	</div>
<?php $this->endWidget(); ?>