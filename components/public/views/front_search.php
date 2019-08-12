<?php
/**
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2013 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */
?>
<?php //begin.Search ?>
<div class="search">
	<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
		'action'=>Yii::app()->createUrl('article/search/index'),
		'enableAjaxValidation'=>true,
		'method'=>'get',
		'id'=>'global-search',
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		)
	)); ?>
		<input type="text" name="search" placeholder="">
		<?php /*<input type="submit" value="Search">*/?>
	<?php $this->endWidget(); ?>
</div>
<?php //end.Search ?>
