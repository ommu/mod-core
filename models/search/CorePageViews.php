<?php
/**
 * CorePageViews
 *
 * CorePageViews represents the model behind the search form about `ommu\core\models\CorePageViews`.
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 ECC UGM (ecc.ft.ugm.ac.id)
 * @created date 2 October 2017, 22:42 WIB
 * @modified date 23 April 2018, 11:43 WIB
 * @link http://ecc.ft.ugm.ac.id
 *
 */

namespace ommu\core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\core\models\CorePageViews as CorePageViewsModel;

class CorePageViews extends CorePageViewsModel
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['view_id', 'publish', 'page_id', 'user_id', 'views'], 'integer'],
			[['view_date', 'view_ip', 'deleted_date', 
				'page_search', 'user_search'], 'safe'],
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
		$query = CorePageViewsModel::find()->alias('t');
		$query->joinWith([
			'page.title page', 
			'user user'
		]);

		// add conditions that should always apply here
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['page_search'] = [
			'asc' => ['page.message' => SORT_ASC],
			'desc' => ['page.message' => SORT_DESC],
		];
		$attributes['user_search'] = [
			'asc' => ['user.displayname' => SORT_ASC],
			'desc' => ['user.displayname' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['view_id' => SORT_DESC],
		]);

		$this->load($params);

		if(!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			't.view_id' => $this->view_id,
			't.page_id' => isset($params['page']) ? $params['page'] : $this->page_id,
			't.user_id' => isset($params['user']) ? $params['user'] : $this->user_id,
			't.views' => $this->views,
			'cast(t.view_date as date)' => $this->view_date,
			'cast(t.deleted_date as date)' => $this->deleted_date,
		]);

		if(isset($params['trash']))
			$query->andFilterWhere(['NOT IN', 't.publish', [0,1]]);
		else {
			if(!isset($params['publish']) || (isset($params['publish']) && $params['publish'] == ''))
				$query->andFilterWhere(['IN', 't.publish', [0,1]]);
			else
				$query->andFilterWhere(['t.publish' => $this->publish]);
		}

		$query->andFilterWhere(['like', 't.view_ip', $this->view_ip])
			->andFilterWhere(['like', 'page.message', $this->page_search])
			->andFilterWhere(['like', 'user.displayname', $this->user_search]);

		return $dataProvider;
	}
}
