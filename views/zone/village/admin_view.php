<?php
/**
 * Core Zone Villages (core-zone-village)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\VillageController
 * @var $model ommu\core\models\CoreZoneVillage
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 16 September 2017, 17:35 WIB
 * @modified date 30 January 2019, 17:15 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Villages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->village_name;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Detail'), 'url' => Url::to(['view', 'id'=>$model->village_id]), 'icon' => 'eye', 'htmlOptions' => ['class'=>'btn btn-success btn-sm']],
	['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id'=>$model->village_id]), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary btn-sm']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->village_id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post', 'class'=>'btn btn-danger btn-sm'], 'icon' => 'trash'],
];
?>

<div class="core-zone-village-view">

<?php echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		'village_id',
		[
			'attribute' => 'publish',
			'value' => $model->quickAction(Url::to(['publish', 'id'=>$model->primaryKey]), $model->publish),
			'format' => 'raw',
		],
		'village_name',
		[
			'attribute' => 'districtName',
			'value' => function ($model) {
				$districtName = isset($model->district) ? $model->district->district_name : '-';
				if($districtName != '-')
					return Html::a($districtName, ['zone/district/view', 'id'=>$model->district_id], ['title'=>$districtName]);
				return $districtName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'cityName',
			'value' => function ($model) {
				$cityName = isset($model->district->city) ? $model->district->city->city_name : '-';
				if($cityName != '-')
					return Html::a($cityName, ['zone/city/view', 'id'=>$model->district->city_id], ['title'=>$cityName]);
				return $cityName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'provinceName',
			'value' => function ($model) {
				$provinceName = isset($model->district->city->province) ? $model->district->city->province->province_name : '-';
				if($provinceName != '-')
					return Html::a($provinceName, ['zone/province/view', 'id'=>$model->district->city->province_id], ['title'=>$provinceName]);
				return $provinceName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'countryName',
			'value' => function ($model) {
				$countryName = isset($model->district->city->province->country) ? $model->district->city->province->country->country_name : '-';
				if($countryName != '-')
					return Html::a($countryName, ['zone/country/view', 'id'=>$model->district->city->province->country_id], ['title'=>$countryName]);
				return $countryName;
			},
			'format' => 'html',
		],
		'zipcode',
		'mfdonline',
		[
			'attribute' => 'creation_date',
			'value' => Yii::$app->formatter->asDatetime($model->creation_date, 'medium'),
		],
		[
			'attribute' => 'creationDisplayname',
			'value' => isset($model->creation) ? $model->creation->displayname : '-',
		],
		[
			'attribute' => 'modified_date',
			'value' => Yii::$app->formatter->asDatetime($model->modified_date, 'medium'),
		],
		[
			'attribute' => 'modifiedDisplayname',
			'value' => isset($model->modified) ? $model->modified->displayname : '-',
		],
		[
			'attribute' => 'updated_date',
			'value' => Yii::$app->formatter->asDatetime($model->updated_date, 'medium'),
		],
		'slug',
	],
]) ?>

</div>