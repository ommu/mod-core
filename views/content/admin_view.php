<?php
/**
 * Ommu Pages (ommu-pages)
 * @var $this ContentController
 * @var $model OmmuPages
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Pages'=>array('manage'),
		$model->title->message,
	);
?>

<div class="box">
	<?php $this->widget('application.libraries.core.components.system.FDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'page_id',
			array(
				'name'=>'publish',
				'value'=>$model->publish == '1' ? CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
				'type'=>'raw',
			),
			array(
				'name'=>'name',
				'value'=>$model->name ? $model->title->message : '-',
			),
			array(
				'name'=>'desc',
				'value'=>$model->desc ? $model->description->message : '-',
				'type'=>'raw',
			),
			array(
				'name'=>'quote',
				'value'=>$model->quote ? $model->quote_r->message : '-',
				'type'=>'raw',
			),
			array(
				'name'=>'media',
				'value'=>$model->media ? CHtml::link($model->media, Yii::app()->request->baseUrl.'/public/page/'.$model->media, array('target' => '_blank')) : '-',
				'type'=>'raw',
			),
			array(
				'name'=>'media_show',
				'value'=>$model->media_show ? Yii::t('phrase', 'Yes') : Yii::t('phrase', 'No'),
			),
			array(
				'name'=>'media_type',
				'value'=>$model->media_type ? Yii::t('phrase', 'Yes') : Yii::t('phrase', 'No'),
			),
			array(
				'name'=>'creation_date',
				'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
			),
			array(
				'name'=>'creation_id',
				'value'=>$model->creation_id ? $model->creation->displayname : '-',
			),
			array(
				'name'=>'modified_date',
				'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
			),
			array(
				'name'=>'modified_id',
				'value'=>$model->modified_id ? $model->modified->displayname : '-',
			),
			array(
				'name'=>'updated_date',
				'value'=>!in_array($model->updated_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->updated_date, true) : '-',
			),
			array(
				'name'=>'slug',
				'value'=>$model->slug ? $model->slug : '-',
			),
		),
	)); ?>
</div>