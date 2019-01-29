<?php
/**
 * CoreMeta
 *
 * CoreMeta represents the model behind the search form about `ommu\core\models\CoreMeta`.
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 24 April 2018, 14:11 WIB
 * @modified date 24 April 2018, 14:11 WIB
 * @modified by Putra Sudaryanto <putra@sudaryanto.id>
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\core\models\CoreMeta as CoreMetaModel;

class CoreMeta extends CoreMetaModel
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'meta_image', 'meta_image_alt', 'office_name', 'office_location', 'office_place', 'office_district', 'office_village', 'office_zipcode', 'office_hour', 'office_phone', 'office_fax', 'office_email', 'office_hotline', 'office_website', 'map_icons', 'map_icon_size', 'twitter_site', 'twitter_creator', 'twitter_photo_size', 'twitter_country', 'twitter_iphone', 'twitter_ipad', 'twitter_googleplay', 'facebook_profile_firstname', 'facebook_profile_lastname', 'facebook_profile_username', 'facebook_sitename', 'facebook_see_also', 'facebook_admins', 'modified_date', 'modified_search'], 'safe'],
			[['office_on', 'office_country_id', 'office_province_id', 'office_city_id', 'google_on', 'twitter_on', 'twitter_card', 'facebook_on', 'facebook_type', 'modified_id'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
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
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = CoreMetaModel::find()->alias('t');
		$query->joinWith([
			'modified modified'
		]);

		// add conditions that should always apply here
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['modified_search'] = [
			'asc' => ['modified.displayname' => SORT_ASC],
			'desc' => ['modified.displayname' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['id' => SORT_DESC],
		]);

		$this->load($params);

		if(!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			't.id' => $this->id,
			't.office_on' => $this->office_on,
			't.office_country_id' => $this->office_country_id,
			't.office_province_id' => $this->office_province_id,
			't.office_city_id' => $this->office_city_id,
			't.google_on' => $this->google_on,
			't.twitter_on' => $this->twitter_on,
			't.twitter_card' => $this->twitter_card,
			't.facebook_on' => $this->facebook_on,
			't.facebook_type' => $this->facebook_type,
			'cast(t.modified_date as date)' => $this->modified_date,
			't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
		]);

		$query->andFilterWhere(['like', 't.meta_image', $this->meta_image])
			->andFilterWhere(['like', 't.meta_image_alt', $this->meta_image_alt])
			->andFilterWhere(['like', 't.office_name', $this->office_name])
			->andFilterWhere(['like', 't.office_location', $this->office_location])
			->andFilterWhere(['like', 't.office_place', $this->office_place])
			->andFilterWhere(['like', 't.office_district', $this->office_district])
			->andFilterWhere(['like', 't.office_village', $this->office_village])
			->andFilterWhere(['like', 't.office_zipcode', $this->office_zipcode])
			->andFilterWhere(['like', 't.office_hour', $this->office_hour])
			->andFilterWhere(['like', 't.office_phone', $this->office_phone])
			->andFilterWhere(['like', 't.office_fax', $this->office_fax])
			->andFilterWhere(['like', 't.office_email', $this->office_email])
			->andFilterWhere(['like', 't.office_hotline', $this->office_hotline])
			->andFilterWhere(['like', 't.office_website', $this->office_website])
			->andFilterWhere(['like', 't.map_icons', $this->map_icons])
			->andFilterWhere(['like', 't.map_icon_size', $this->map_icon_size])
			->andFilterWhere(['like', 't.twitter_site', $this->twitter_site])
			->andFilterWhere(['like', 't.twitter_creator', $this->twitter_creator])
			->andFilterWhere(['like', 't.twitter_photo_size', $this->twitter_photo_size])
			->andFilterWhere(['like', 't.twitter_country', $this->twitter_country])
			->andFilterWhere(['like', 't.twitter_iphone', $this->twitter_iphone])
			->andFilterWhere(['like', 't.twitter_ipad', $this->twitter_ipad])
			->andFilterWhere(['like', 't.twitter_googleplay', $this->twitter_googleplay])
			->andFilterWhere(['like', 't.facebook_profile_firstname', $this->facebook_profile_firstname])
			->andFilterWhere(['like', 't.facebook_profile_lastname', $this->facebook_profile_lastname])
			->andFilterWhere(['like', 't.facebook_profile_username', $this->facebook_profile_username])
			->andFilterWhere(['like', 't.facebook_sitename', $this->facebook_sitename])
			->andFilterWhere(['like', 't.facebook_see_also', $this->facebook_see_also])
			->andFilterWhere(['like', 't.facebook_admins', $this->facebook_admins])
			->andFilterWhere(['like', 'modified.displayname', $this->modified_search]);

		return $dataProvider;
	}
}
