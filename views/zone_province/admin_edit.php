<?php
/**
 * Ommu Zone Provinces (ommu-zone-province)
 * @var $this ZoneprovinceController
 * @var $model OmmuZoneProvince
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Zone Provinces'=>array('manage'),
		$model->province_id=>array('view','id'=>$model->province_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('/zone_province/_form', array('model'=>$model)); ?>
</div>
