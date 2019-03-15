<?php
/**
 * CoreSettings
 *
 * CoreSettings represents the model behind the search form about `ommu\core\models\CoreSettings`.
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 23 April 2018, 18:49 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\core\models\CoreSettings as CoreSettingsModel;

class CoreSettings extends CoreSettingsModel
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'site_url', 'site_title', 'site_keywords', 'site_description', 'site_creation', 'site_dateformat', 'site_timeformat', 'construction_date', 'construction_text', 'event_startdate', 'event_finishdate', 'event_tag', 'signup_numgiven', 'general_include', 'general_commenthtml', 'banned_ips', 'banned_emails', 'banned_usernames', 'banned_words', 'spam_failedcount', 'analytic_id', 'analytic_profile_id', 'license_email', 'license_key', 'ommu_version', 'modified_date', 'modified_search'], 'safe'],
			[['online', 'site_oauth', 'site_type', 'signup_username', 'signup_approve', 'signup_verifyemail', 'signup_photo', 'signup_welcome', 'signup_random', 'signup_terms', 'signup_invitepage', 'signup_inviteonly', 'signup_checkemail', 'signup_adminemail', 'general_profile', 'general_invite', 'general_search', 'general_portal', 'lang_allow', 'lang_autodetect', 'lang_anonymous', 'spam_comment', 'spam_contact', 'spam_invite', 'spam_login', 'spam_signup', 'analytic', 'modified_id'], 'integer'],
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
	 * @return ActiveDataProvider
	 */
	public function search($params, $column=null)
	{
		if(!($column && is_array($column)))
			$query = CoreSettingsModel::find()->alias('t');
		else
			$query = CoreSettingsModel::find()->alias('t')->select($column);
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
			't.online' => $this->online,
			't.site_oauth' => $this->site_oauth,
			't.site_type' => $this->site_type,
			'cast(t.site_creation as date)' => $this->site_creation,
			'cast(t.construction_date as date)' => $this->construction_date,
			'cast(t.event_startdate as date)' => $this->event_startdate,
			'cast(t.event_finishdate as date)' => $this->event_finishdate,
			't.signup_username' => $this->signup_username,
			't.signup_approve' => $this->signup_approve,
			't.signup_verifyemail' => $this->signup_verifyemail,
			't.signup_photo' => $this->signup_photo,
			't.signup_welcome' => $this->signup_welcome,
			't.signup_random' => $this->signup_random,
			't.signup_terms' => $this->signup_terms,
			't.signup_invitepage' => $this->signup_invitepage,
			't.signup_inviteonly' => $this->signup_inviteonly,
			't.signup_checkemail' => $this->signup_checkemail,
			't.signup_numgiven' => $this->signup_numgiven,
			't.signup_adminemail' => $this->signup_adminemail,
			't.general_profile' => $this->general_profile,
			't.general_invite' => $this->general_invite,
			't.general_search' => $this->general_search,
			't.general_portal' => $this->general_portal,
			't.lang_allow' => $this->lang_allow,
			't.lang_autodetect' => $this->lang_autodetect,
			't.lang_anonymous' => $this->lang_anonymous,
			't.spam_comment' => $this->spam_comment,
			't.spam_contact' => $this->spam_contact,
			't.spam_invite' => $this->spam_invite,
			't.spam_login' => $this->spam_login,
			't.spam_failedcount' => $this->spam_failedcount,
			't.spam_signup' => $this->spam_signup,
			't.analytic' => $this->analytic,
			'cast(t.modified_date as date)' => $this->modified_date,
			't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
		]);

		$query->andFilterWhere(['like', 't.site_url', $this->site_url])
			->andFilterWhere(['like', 't.site_title', $this->site_title])
			->andFilterWhere(['like', 't.site_keywords', $this->site_keywords])
			->andFilterWhere(['like', 't.site_description', $this->site_description])
			->andFilterWhere(['like', 't.site_dateformat', $this->site_dateformat])
			->andFilterWhere(['like', 't.site_timeformat', $this->site_timeformat])
			->andFilterWhere(['like', 't.construction_text', $this->construction_text])
			->andFilterWhere(['like', 't.event_tag', $this->event_tag])
			->andFilterWhere(['like', 't.general_include', $this->general_include])
			->andFilterWhere(['like', 't.general_commenthtml', $this->general_commenthtml])
			->andFilterWhere(['like', 't.banned_ips', $this->banned_ips])
			->andFilterWhere(['like', 't.banned_emails', $this->banned_emails])
			->andFilterWhere(['like', 't.banned_usernames', $this->banned_usernames])
			->andFilterWhere(['like', 't.banned_words', $this->banned_words])
			->andFilterWhere(['like', 't.analytic_id', $this->analytic_id])
			->andFilterWhere(['like', 't.analytic_profile_id', $this->analytic_profile_id])
			->andFilterWhere(['like', 't.license_email', $this->license_email])
			->andFilterWhere(['like', 't.license_key', $this->license_key])
			->andFilterWhere(['like', 't.ommu_version', $this->ommu_version])
			->andFilterWhere(['like', 'modified.displayname', $this->modified_search]);

		return $dataProvider;
	}
}
