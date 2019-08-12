<?php
/**
 * Core Tags (core-tags)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\TagController
 * @var $model ommu\core\models\CoreTags
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 00:14 WIB
 * @modified date 31 January 2019, 16:40 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="core-tags-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
