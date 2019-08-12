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
		$model->name=>array('view','id'=>$model->plugin_id),
		Yii::t('phrase', 'Update'),
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>