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
<div name="post-on">
	<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
		'id'=>'ommu-walls-form',
		'action'=>Yii::app()->createUrl('wall/post'),
		'enableAjaxValidation'=>true,
	)); ?>
	<fieldset>
		<div>
			<?php echo $form->textArea($model,'wall_status', array('rows'=>6, 'cols'=>50, 'class'=>'span-11 smaller', 'placeholder'=>'Post your status..')); ?>
		</div>
		<div class="clearfix">
			<?php echo CHtml::submitButton('Share', array('onclick' => 'setEnableSave()')); ?>
			<?php echo $form->error($model,'wall_status'); ?>
		</div>
	</fieldset>
	<?php $this->endWidget(); ?>
</div>