<?php
/**
 * Core Zone Countries (core-zone-country)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\CountryController
 * @var $model ommu\core\models\CoreZoneCountry
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 8 September 2017, 11:45 WIB
 * @modified date 30 January 2019, 17:13 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['/setting/update']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zone'), 'url' => ['zone/country/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="core-zone-country-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
