<?php
/**
 * Messages (message)
 * @var $this TranslateController
 * @var $model Message
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 Ommu Platform (opensource.ommu.co)
 * @created date 21 January 2018, 09:03 WIB
 * @modified date 21 January 2018, 09:03 WIB
 * @link http://opensource.ommu.co
 *
 */

	$this->breadcrumbs=array(
		'Messages'=>array('manage'),
		$model->id=>array('view','id'=>$model->id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
