<?php
/**
 * Core Pages (core-pages)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\page\AdminController
 * @var $model ommu\core\models\CorePages
 * @var $form app\components\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 16:08 WIB
 * @modified date 31 January 2019, 16:38 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Back To Manage'), 'url' => Url::to(['index']), 'icon' => 'table'],
];
?>

<div class="core-pages-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
