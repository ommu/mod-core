<?php
/**
 * Core Zone Cities (core-zone-city)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\CityController
 * @var $model ommu\core\models\CoreZoneCity
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 14 September 2017, 22:22 WIB
 * @modified date 30 January 2019, 17:13 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->city_name;

if(!$small) {
$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Detail'), 'url' => Url::to(['view', 'id'=>$model->city_id]), 'icon' => 'eye', 'htmlOptions' => ['class'=>'btn btn-success']],
	['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id'=>$model->city_id]), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->city_id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
} ?>

<div class="core-zone-city-view">

<?php echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		'city_id',
		[
			'attribute' => 'publish',
			'value' => $model->quickAction(Url::to(['publish', 'id'=>$model->primaryKey]), $model->publish),
			'format' => 'raw',
		],
		'city_name',
		[
			'attribute' => 'provinceName',
			'value' => function ($model) {
				$provinceName = isset($model->province) ? $model->province->province_name : '-';
				if($provinceName != '-')
					return Html::a($provinceName, ['zone/province/view', 'id'=>$model->province_id], ['title'=>$provinceName]);
				return $provinceName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'countryName',
			'value' => function ($model) {
				$countryName = isset($model->province->country) ? $model->province->country->country_name : '-';
				if($countryName != '-')
					return Html::a($countryName, ['zone/country/view', 'id'=>$model->province->country_id], ['title'=>$countryName]);
				return $countryName;
			},
			'format' => 'html',
		],
		'mfdonline',
		[
			'attribute' => 'checked',
			'value' => $model->filterYesNo($model->checked),
		],
		[
			'attribute' => 'creation_date',
			'value' => Yii::$app->formatter->asDatetime($model->creation_date, 'medium'),
			'visible' => !$small,
		],
		[
			'attribute' => 'creationDisplayname',
			'value' => isset($model->creation) ? $model->creation->displayname : '-',
			'visible' => !$small,
		],
		[
			'attribute' => 'modified_date',
			'value' => Yii::$app->formatter->asDatetime($model->modified_date, 'medium'),
			'visible' => !$small,
		],
		[
			'attribute' => 'modifiedDisplayname',
			'value' => isset($model->modified) ? $model->modified->displayname : '-',
			'visible' => !$small,
		],
		[
			'attribute' => 'updated_date',
			'value' => Yii::$app->formatter->asDatetime($model->updated_date, 'medium'),
			'visible' => !$small,
		],
		[
			'attribute' => 'slug',
			'value' => $model->slug ? $model->slug : '-',
			'visible' => !$small,
		],
		[
			'attribute' => 'districts',
			'value' => function ($model) {
				$districts = $model->getDistricts(true);
				return Html::a($districts, ['zone/district/manage', 'city'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} districts', ['count'=>$districts])]);
			},
			'format' => 'html',
			'visible' => !$small,
		],
	],
]); ?>

</div>