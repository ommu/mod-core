<?php
/**
 * Core Zone Cities (core-zone-city)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\CityController
 * @var $model ommu\core\models\CoreZoneCity
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 14 September 2017, 22:22 WIB
 * @modified date 30 January 2019, 17:13 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['/setting/update']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zone'), 'url' => ['zone/country/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="core-zone-city-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
