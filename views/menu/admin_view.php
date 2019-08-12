<?php
/**
 * Ommu Menus (ommu-menu)
 * @var $this MenuController
 * @var $model OmmuMenus
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 24 March 2016, 10:20 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Menus'=>array('manage'),
		$model->title->message,
	);
?>

<div class="dialog-content">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'id',
				'value'=>$model->id,
			),
			array(
				'name'=>'publish',
				'value'=>$this->quickAction(Yii::app()->controller->createUrl('publish', array('id'=>$model->id)), $model->publish),
				'type'=>'raw',
			),
			array(
				'name'=>'cat_id',
				'value'=>$model->cat_id ? $model->category->title->message : '-',
			),
			array(
				'name'=>'name',
				'value'=>$model->title->message,
			),
			array(
				'name'=>'parent_id',
				'value'=>$model->parent_id ? $model->parent->title->message : '-',
			),
			array(
				'name'=>'orders',
				'value'=>$model->orders,
			),
			array(
				'name'=>'url',
				'value'=>$model->url ? $model->url : '-',
			),
			array(
				'name'=>'attr',
				'value'=>$model->attr ? $model->attr : '-',
			),
			array(
				'name'=>'sitetype_access',
				'value'=>$model->sitetype_access != '' ? $this->renderPartial('_view_sitetype', array('sitetype_access'=>unserialize($model->sitetype_access)), true, false) : '-',
				'type'=>'raw',
			),
			array(
				'name'=>'sitetype_access',
				'value'=>$model->userlevel_access != '' ? $this->renderPartial('_view_userlevel', array('userlevel_access'=>unserialize($model->userlevel_access)), true, false) : '-',
				'type'=>'raw',
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->creation_date) : '-',
			),
			array(
				'name'=>'creation_search',
				'value'=>$model->creation->displayname ? $model->creation->displayname : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->modified_date) : '-',
			),
			array(
				'name'=>'modified_search',
				'value'=>$model->modified->displayname ? $model->modified->displayname : '-',
			),
			array(
				'name'=>'updated_date',
				'value'=>!in_array($model->updated_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->updated_date) : '-',
			),
		),
	)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
