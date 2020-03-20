<?php
/**
 * Core Languages (core-languages)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\LanguageController
 * @var $model ommu\core\models\CoreLanguages
 * @var $form app\components\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 2 October 2017, 08:40 WIB
 * @modified date 22 March 2019, 17:18 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['/setting/update']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Languages'), 'url' => ['setting/language']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'i18n Package'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create');
?>

<div class="core-languages-create">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>
