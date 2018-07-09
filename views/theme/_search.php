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
?>

<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('theme_id'); ?><br/>
			<?php echo $form->textField($model,'theme_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('group_page'); ?><br/>
			<?php echo $form->textField($model,'group_page'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('default_theme'); ?><br/>
			<?php echo $form->textField($model,'default_theme'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('folder'); ?><br/>
			<?php echo $form->textField($model,'folder'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('layout'); ?><br/>
			<?php echo $form->textField($model,'layout'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('name'); ?><br/>
			<?php echo $form->textField($model,'name'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('thumbnail'); ?><br/>
			<?php echo $form->textField($model,'thumbnail'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_id'); ?><br/>
			<?php echo $form->textField($model,'creation_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
