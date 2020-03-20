<?php
/**
 * CoreZoneVillage
 *
 * CoreZoneVillage represents the model behind the search form about `ommu\core\models\CoreZoneVillage`.
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 16 September 2017, 17:35 WIB
 * @modified date 30 January 2019, 17:14 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\core\models\CoreZoneVillage as CoreZoneVillageModel;

class CoreZoneVillage extends CoreZoneVillageModel
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['village_id', 'publish', 'district_id', 'creation_id', 'modified_id'], 'integer'],
			[['village_name', 'zipcode', 'mfdonline', 'creation_date', 'modified_date', 'updated_date', 'slug',
				'districtName', 'creationDisplayname', 'modifiedDisplayname', 'cityName', 'provinceName', 'countryName'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Tambahkan fungsi beforeValidate ini pada model search untuk menumpuk validasi pd model induk. 
	 * dan "jangan" tambahkan parent::beforeValidate, cukup "return true" saja.
	 * maka validasi yg akan dipakai hanya pd model ini, semua script yg ditaruh di beforeValidate pada model induk
	 * tidak akan dijalankan.
	 */
	public function beforeValidate() {
		return true;
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params, $column=null)
	{
		if(!($column && is_array($column)))
			$query = CoreZoneVillageModel::find()->alias('t');
		else
			$query = CoreZoneVillageModel::find()->alias('t')->select($column);
		$query->joinWith([
			'district district', 
			'creation creation', 
			'modified modified',
			'district.city city', 
			'district.city.province province', 
			'district.city.province.country country',
		])
		->groupBy(['village_id']);

		// add conditions that should always apply here
		$dataParams = [
			'query' => $query,
		];
		// disable pagination agar data pada api tampil semua
		if(isset($params['pagination']) && $params['pagination'] == 0)
			$dataParams['pagination'] = false;
		$dataProvider = new ActiveDataProvider($dataParams);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['districtName'] = [
			'asc' => ['district.district_name' => SORT_ASC],
			'desc' => ['district.district_name' => SORT_DESC],
		];
		$attributes['creationDisplayname'] = [
			'asc' => ['creation.displayname' => SORT_ASC],
			'desc' => ['creation.displayname' => SORT_DESC],
		];
		$attributes['modifiedDisplayname'] = [
			'asc' => ['modified.displayname' => SORT_ASC],
			'desc' => ['modified.displayname' => SORT_DESC],
		];
		$attributes['cityName'] = [
			'asc' => ['city.city_name' => SORT_ASC],
			'desc' => ['city.city_name' => SORT_DESC],
		];
		$attributes['provinceName'] = [
			'asc' => ['province.province_name' => SORT_ASC],
			'desc' => ['province.province_name' => SORT_DESC],
		];
		$attributes['countryName'] = [
			'asc' => ['country.country_name' => SORT_ASC],
			'desc' => ['country.country_name' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['village_id' => SORT_DESC],
		]);

		$this->load($params);

		if(!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			't.village_id' => $this->village_id,
			't.district_id' => isset($params['district']) ? $params['district'] : $this->district_id,
			'cast(t.creation_date as date)' => $this->creation_date,
			't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
			'cast(t.modified_date as date)' => $this->modified_date,
			't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
			'cast(t.updated_date as date)' => $this->updated_date,
		]);

		if(isset($params['city']))
			$query->andFilterWhere(['city.city_id' => $params['city']]);
		if(isset($params['province']))
			$query->andFilterWhere(['province.province_id' => $params['province']]);
		if(isset($params['country']))
			$query->andFilterWhere(['country.country_id' => $params['country']]);

		if(isset($params['trash']))
			$query->andFilterWhere(['NOT IN', 't.publish', [0,1]]);
		else {
			if(!isset($params['publish']) || (isset($params['publish']) && $params['publish'] == ''))
				$query->andFilterWhere(['IN', 't.publish', [0,1]]);
			else
				$query->andFilterWhere(['t.publish' => $this->publish]);
		}

		$query->andFilterWhere(['like', 't.village_name', $this->village_name])
			->andFilterWhere(['like', 't.zipcode', $this->zipcode])
			->andFilterWhere(['like', 't.mfdonline', $this->mfdonline])
			->andFilterWhere(['like', 't.slug', $this->slug])
			->andFilterWhere(['like', 'district.district_name', $this->districtName])
			->andFilterWhere(['like', 'creation.displayname', $this->creationDisplayname])
			->andFilterWhere(['like', 'modified.displayname', $this->modifiedDisplayname])
			->andFilterWhere(['like', 'city.city_name', $this->cityName])
			->andFilterWhere(['like', 'province.province_name', $this->provinceName])
			->andFilterWhere(['like', 'country.country_name', $this->countryName]);

		return $dataProvider;
	}
}
