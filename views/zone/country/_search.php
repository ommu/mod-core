<?php
/**
 * Core Zone Countries (core-zone-country)
 * @var $this yii\web\View
 * @var $this ommu\core\controllers\zone\CountryController
 * @var $model ommu\core\models\search\CoreZoneCountry
 * @var $form yii\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 8 September 2017, 11:45 WIB
 * @modified date 24 April 2018, 22:41 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use app\components\ActiveForm;
?>

<div class="search-form">
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>
		<?php echo $form->field($model, 'country_name');?>

		<?php echo $form->field($model, 'code');?>

		<?php echo $form->field($model, 'creation_date')
			->input('date');?>

		<?php echo $form->field($model, 'creation_search');?>

		<?php echo $form->field($model, 'modified_date')
			->input('date');?>

		<?php echo $form->field($model, 'modified_search');?>

		<?php echo $form->field($model, 'slug');?>

		<div class="form-group">
			<?php echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
			<?php echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
		</div>
	<?php ActiveForm::end(); ?>
</div>