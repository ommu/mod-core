<?php
/**
 * Core Pages (core-pages)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\page\AdminController
 * @var $model ommu\core\models\CorePages
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 2 October 2017, 16:08 WIB
 * @modified date 31 January 2019, 16:38 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publication'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="core-pages-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
