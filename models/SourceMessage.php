<?php
/**
 * SourceMessage
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 15 September 2017, 19:07 WIB
 * @modified date 22 March 2019, 18:23 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "source_message".
 *
 * The followings are the available columns in table "source_message":
 * @property integer $id
 * @property string $category
 * @property string $message
 * @property string $location
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 *
 * The followings are the available model relations:
 * @property Message[] $translates
 * @property Users $creation
 * @property Users $modified
 *
 */

namespace ommu\core\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Inflector;
use ommu\core\models\Message;
use ommu\users\models\Users;
use yii\helpers\ArrayHelper;

class SourceMessage extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = ['modified_date', 'modifiedDisplayname'];

	public $creationDisplayname;
	public $modifiedDisplayname;

	public $translate = [];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'source_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['message'], 'required'],
			[['creation_id', 'modified_id'], 'integer'],
			[['message', 'location'], 'string'],
			[['translate'], 'safe'],
			[['category'], 'string', 'max' => 255],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'category' => Yii::t('app', 'Category'),
			'message' => Yii::t('app', 'Message'),
			'location' => Yii::t('app', 'Location'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'translates' => Yii::t('app', 'Translates'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
			'translate' => Yii::t('app', 'Translate'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTranslates($count=false)
	{
		if($count == false)
			return $this->hasMany(Message::className(), ['id' => 'id'])
				->select(['language', 'translation']);

		$model = Message::find()
			->alias('t')
			->where(['t.id' => $this->id])
			->andWhere(['<>', 't.translation', '']);
		$translates = $model->count();

		return $translates ? $translates : 0;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCreation()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'creation_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModified()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'modified_id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\query\SourceMessage the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\core\models\query\SourceMessage(get_called_class());
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
		parent::init();

		if(!(Yii::$app instanceof \app\components\Application))
			return;

		if(!$this->hasMethod('search'))
			return;

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'app\components\grid\SerialColumn',
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['category'] = [
			'attribute' => 'category',
			'value' => function($model, $key, $index, $column) {
				return $model->category;
			},
		];
		$this->templateColumns['message'] = [
			'attribute' => 'message',
			'value' => function($model, $key, $index, $column) {
				return $model->message;
			},
			'format' => 'html',
		];
		$this->templateColumns['location'] = [
			'attribute' => 'location',
			'value' => function($model, $key, $index, $column) {
				return $model->location;
			},
		];
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->creation_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'creation_date'),
		];
		$this->templateColumns['creationDisplayname'] = [
			'attribute' => 'creationDisplayname',
			'value' => function($model, $key, $index, $column) {
				return isset($model->creation) ? $model->creation->displayname : '-';
				// return $model->creationDisplayname;
			},
			'visible' => !Yii::$app->request->get('creation') ? true : false,
		];
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->modified_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'modified_date'),
		];
		$this->templateColumns['modifiedDisplayname'] = [
			'attribute' => 'modifiedDisplayname',
			'value' => function($model, $key, $index, $column) {
				return isset($model->modified) ? $model->modified->displayname : '-';
				// return $model->modifiedDisplayname;
			},
			'visible' => !Yii::$app->request->get('modified') ? true : false,
		];
		$this->templateColumns['translates'] = [
			'attribute' => 'translates',
			'value' => function($model, $key, $index, $column) {
				return $model->getTranslates(true);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'text-center'],
			'format' => 'html',
		];
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::find();
			if(is_array($column))
				$model->select($column);
			else
				$model->select([$column]);
			$model = $model->where(['id' => $id])->one();
			return is_array($column) ? $model : $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}

	/**
	 * function getLanguages
	 */
	public function getLanguages()
	{
		return CoreLanguages::getLanguage(true, 'code');
	}

	/**
	 * function setMessage
	 */
	public static function setMessage($message)
	{
		$model = new SourceMessage();
		$model->message = $message;
		$model->location = 'archive-storage_title';
		$model->save();

		return $model->id;
	}

	/**
	 * function parseAnswer
	 */
	public static function parseTranslate($translate, $sep='li')
	{
		if(!is_array($translate) || (is_array($translate) && empty($translate)))
			return '-';

		if($sep == 'li') {
			return Html::ul($translate, ['item' => function($item, $index) {
				$languages = self::getLanguages();
				return Html::tag('li', $languages[$index].': '.($item ? $item : '-'));
			}, 'class'=>'list-boxed']);
		}

		return implode($sep, $translate);
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';

		if(!empty($this->getLanguages()))
			$this->translate = ArrayHelper::map($this->translates, 'language', 'translation');
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				if($this->creation_id == null)
					$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			} else {
				if($this->modified_id == null)
					$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			}
		}
		return true;
	}

	/**
	 * before save attributes
	 */
	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {
			if($insert) {
				if($this->location == null) {
					$module = strtolower(Yii::$app->controller->module->id);
					$controller = strtolower(Yii::$app->controller->id);

					$this->location = $module == null ? $controller : $module.' '.$controller;
				}

				$this->location = Inflector::slug($this->location);
			}
		}
		return true;
	}

	/**
	 * After save attributes
	 */
	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);

		// insert and update translate message
		if(!empty($this->getLanguages())) {
			foreach ($this->translate as $key => $value) {
				$model = Message::find()->alias('t')
					->select(['t.id', 't.language'])
					->where(['t.id' => $this->id])
					->andWhere(['t.language' => $key])
					->one();

				if($value == '') {
					if($model == null)
						continue;
					$model->updateAttributes(['translation' => $value]);

				} else {
					if($model == null) {
						$data = new Message();
						$data->id = $this->id;
						$data->language = $key;
						$data->translation = $value;
						$data->save();
					} else 
						$model->updateAttributes(['translation' => $value]);
				}
			}
		}
	}
}
