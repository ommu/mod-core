<?php
/**
 * Message
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 15 September 2017, 19:16 WIB
 * @modified date 22 March 2019, 18:27 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "message".
 *
 * The followings are the available columns in table "message":
 * @property integer $id
 * @property string $language
 * @property string $translation
 * @property string $creation_date
 * @property integer $creation_id
 *
 * The followings are the available model relations:
 * @property SourceMessage $phrase
 * @property Users $creation
 *
 */

namespace ommu\core\models;

use Yii;
use app\models\Users;

class Message extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	public $message;
	public $creationDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['id', 'language', 'translation'], 'required'],
			[['id', 'creation_id'], 'integer'],
			[['translation', 'message'], 'string'],
			[['language'], 'string', 'max' => 6],
			[['id', 'language'], 'unique', 'targetAttribute' => ['id', 'language']],
			[['id'], 'exist', 'skipOnError' => true, 'targetClass' => SourceMessage::className(), 'targetAttribute' => ['id' => 'id']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'language' => Yii::t('app', 'Language'),
			'translation' => Yii::t('app', 'Translation'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'message' => Yii::t('app', 'Phrase'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPhrase()
	{
		return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCreation()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'creation_id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\query\Message the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\core\models\query\Message(get_called_class());
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
        parent::init();

        if (!(Yii::$app instanceof \app\components\Application)) {
            return;
        }

        if (!$this->hasMethod('search')) {
            return;
        }

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'app\components\grid\SerialColumn',
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['message'] = [
			'attribute' => 'message',
			'value' => function($model, $key, $index, $column) {
				return isset($model->phrase) ? $model->phrase->message : '-';
				// return $model->message;
			},
			'format' => 'html',
			'visible' => !Yii::$app->request->get('phrase') ? true : false,
		];
		$this->templateColumns['language'] = [
			'attribute' => 'language',
			'value' => function($model, $key, $index, $column) {
				return $model->language;
			},
			'filter' => CoreLanguages::getLanguage(true, 'code'),
		];
		$this->templateColumns['translation'] = [
			'attribute' => 'translation',
			'value' => function($model, $key, $index, $column) {
				return $model->translation;
			},
			'format' => 'html',
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
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
        if ($column != null) {
            $model = self::find();
            if (is_array($column)) {
                $model->select($column);
            } else {
                $model->select([$column]);
            }
            $model = $model->where(['id' => $id])->one();
            return is_array($column) ? $model : $model->$column;

        } else {
            $model = self::findOne($id);
            return $model;
        }
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->message = isset($this->phrase) ? $this->phrase->message : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
        if (parent::beforeValidate()) {
            if ($this->isNewRecord) {
                if ($this->creation_id == null) {
                    $this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
                }
            }
        }
        return true;
	}
}
