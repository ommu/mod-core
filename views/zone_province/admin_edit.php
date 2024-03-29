<?php
/**
 * Ommu Zone Provinces (ommu-zone-province)
 * @var $this ZoneprovinceController
 * @var $model OmmuZoneProvince
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2015 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Zone Provinces'=>array('manage'),
		$model->province_id=>array('view','id'=>$model->province_id),
		Yii::t('phrase', 'Update'),
	);
?>

<div class="form">
	<?php echo $this->renderPartial('/zone_province/_form', array('model'=>$model)); ?>
</div>
