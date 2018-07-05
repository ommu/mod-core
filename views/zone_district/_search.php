<?php
/**
 * Ommu Zone Districts (ommu-zone-district)
 * @var $this ZonedistrictController
 * @var $model OmmuZoneDistrict
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2015 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('district_id'); ?><br/>
			<?php echo $form->textField($model,'district_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('city_id'); ?><br/>
			<?php echo $form->textField($model,'city_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('district_name'); ?><br/>
			<?php echo $form->textField($model,'district_name'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('mfdonline'); ?><br/>
			<?php echo $form->textField($model,'mfdonline'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('checked'); ?><br/>
			<?php echo $form->textField($model,'checked'); ?>
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

		<li>
			<?php echo $model->getAttributeLabel('updated_date'); ?><br/>
			<?php echo $form->textField($model,'updated_date'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
