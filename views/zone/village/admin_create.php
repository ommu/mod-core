<?php
/**
 * Core Zone Villages (core-zone-village)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\VillageController
 * @var $model ommu\core\models\CoreZoneVillage
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 16 September 2017, 17:35 WIB
 * @modified date 30 January 2019, 17:15 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Villages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="core-zone-village-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
