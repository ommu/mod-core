<?php
/**
 * CorePages
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 2 October 2017, 16:08 WIB
 * @modified date 31 January 2019, 16:06 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_pages".
 *
 * The followings are the available columns in table "ommu_core_pages":
 * @property integer $page_id
 * @property integer $publish
 * @property integer $name
 * @property integer $desc
 * @property integer $quote
 * @property string $media
 * @property integer $media_show
 * @property integer $media_type
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 * @property string $updated_date
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property CorePageViews[] $views
 * @property SourceMessage $title
 * @property SourceMessage $description
 * @property SourceMessage $quoteRltn
 * @property Users $creation
 * @property Users $modified
 *
 */

namespace ommu\core\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\behaviors\SluggableBehavior;
use thamtech\uuid\helpers\UuidHelper;
use app\models\SourceMessage;
use ommu\users\models\Users;
use ommu\core\models\view\CorePages as CorePagesView;

class CorePages extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;
	use \ommu\traits\FileTrait;

	public $gridForbiddenColumn = ['desc_i', 'quote_i', 'media', 'media_show', 'media_type', 'modified_date', 'modifiedDisplayname', 'updated_date', 'slug'];
	public $name_i;
	public $desc_i;
	public $quote_i;
	public $old_media;
	public $creationDisplayname;
	public $modifiedDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_core_pages';
	}

	/**
	 * behaviors model class.
	 */
	public function behaviors() {
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'title.message',
				'immutable' => true,
				'ensureUnique' => true,
			],
		];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['name_i', 'desc_i'], 'required'],
			[['publish', 'name', 'desc', 'quote', 'media_show', 'media_type', 'creation_id', 'modified_id'], 'integer'],
			[['name_i', 'desc_i', 'quote_i', 'media', 'slug'], 'string'],
			[['media', 'quote_i'], 'safe'],
			[['name_i'], 'string', 'max' => 64],
			[['quote_i'], 'string', 'max' => 128],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'page_id' => Yii::t('app', 'Page'),
			'publish' => Yii::t('app', 'Publish'),
			'name' => Yii::t('app', 'Name'),
			'desc' => Yii::t('app', 'Description'),
			'quote' => Yii::t('app', 'Quote'),
			'media' => Yii::t('app', 'Media'),
			'media_show' => Yii::t('app', 'Media Show'),
			'media_type' => Yii::t('app', 'Media Type'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'slug' => Yii::t('app', 'Slug'),
			'name_i' => Yii::t('app', 'Name'),
			'desc_i' => Yii::t('app', 'Description'),
			'quote_i' => Yii::t('app', 'Quote'),
			'old_media' => Yii::t('app', 'Old Media'),
			'views' => Yii::t('app', 'Views'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getViews($count=true, $publish=1)
	{
		if($count == true) {
			$model = CorePageViews::find()
				->where(['page_id' => $this->page_id]);
			if($publish == 0)
				$model->unpublish();
			elseif($publish == 1)
				$model->published();
			elseif($publish == 2)
				$model->deleted();

			return $model->sum('views');
		}

		return $this->hasMany(CorePageViews::className(), ['page_id' => 'page_id'])
			->andOnCondition([sprintf('%s.publish', CorePageViews::tableName()) => $publish]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTitle()
	{
		return $this->hasOne(SourceMessage::className(), ['id' => 'name']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDescription()
	{
		return $this->hasOne(SourceMessage::className(), ['id' => 'desc']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getQuoteRltn()
	{
		return $this->hasOne(SourceMessage::className(), ['id' => 'quote']);
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
	 * @return \yii\db\ActiveQuery
	 */
	public function getView()
	{
		return $this->hasOne(CorePagesView::className(), ['page_id' => 'page_id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\query\CorePages the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\core\models\query\CorePages(get_called_class());
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
		parent::init();

		$this->templateColumns['_no'] = [
			'header' => Yii::t('app', 'No'),
			'class'  => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['name_i'] = [
			'attribute' => 'name_i',
			'value' => function($model, $key, $index, $column) {
				return $model->name_i;
			},
		];
		$this->templateColumns['desc_i'] = [
			'attribute' => 'desc_i',
			'value' => function($model, $key, $index, $column) {
				return $model->desc_i;
			},
			'format' => 'html',
		];
		$this->templateColumns['quote_i'] = [
			'attribute' => 'quote_i',
			'value' => function($model, $key, $index, $column) {
				return $model->quote_i;
			},
		];
		$this->templateColumns['media'] = [
			'attribute' => 'media',
			'value' => function($model, $key, $index, $column) {
				$uploadPath = self::getUploadPath(false);
				return $model->media ? Html::img(join('/', [Url::Base(), $uploadPath, $model->media]), ['alt' => $model->media]) : '-';
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
		if(!Yii::$app->request->get('creation')) {
			$this->templateColumns['creationDisplayname'] = [
				'attribute' => 'creationDisplayname',
				'value' => function($model, $key, $index, $column) {
					return isset($model->creation) ? $model->creation->displayname : '-';
				},
			];
		}
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->modified_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'modified_date'),
		];
		if(!Yii::$app->request->get('modified')) {
			$this->templateColumns['modifiedDisplayname'] = [
				'attribute' => 'modifiedDisplayname',
				'value' => function($model, $key, $index, $column) {
					return isset($model->modified) ? $model->modified->displayname : '-';
				},
			];
		}
		$this->templateColumns['updated_date'] = [
			'attribute' => 'updated_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->updated_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'updated_date'),
		];
		$this->templateColumns['slug'] = [
			'attribute' => 'slug',
			'value' => function($model, $key, $index, $column) {
				return $model->slug;
			},
		];
		$this->templateColumns['views'] = [
			'attribute' => 'views',
			'filter' => false,
			'value' => function($model, $key, $index, $column) {
				return Html::a($model->views ? $model->views : 0, ['page/view/manage', 'page'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} views', ['count'=>$model->views])]);
			},
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		$this->templateColumns['media_show'] = [
			'attribute' => 'media_show',
			'filter' => self::getMediaShow(),
			'value' => function($model, $key, $index, $column) {
				return self::getMediaShow($model->media_show);
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['media_type'] = [
			'attribute' => 'media_type',
			'filter' => self::getMediaType(),
			'value' => function($model, $key, $index, $column) {
				return self::getMediaType($model->media_type);
			},
			'contentOptions' => ['class'=>'center'],
		];
		if(!Yii::$app->request->get('trash')) {
			$this->templateColumns['publish'] = [
				'attribute' => 'publish',
				'filter' => $this->filterYesNo(),
				'value' => function($model, $key, $index, $column) {
					$url = Url::to(['publish', 'id'=>$model->primaryKey]);
					return $this->quickAction($url, $model->publish);
				},
				'contentOptions' => ['class'=>'center'],
				'format' => 'raw',
			];
		}
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::find()
				->select([$column])
				->where(['page_id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}

	/**
	 * function getPage
	 */
	public static function getPage($publish=null, $array=true) 
	{
		$model = self::find()->alias('t');
		$model->leftJoin(sprintf('%s title', SourceMessage::tableName()), 't.name=title.id');
		if($publish != null)
			$model->andWhere(['t.publish' => $publish]);

		$model = $model->orderBy('title.message ASC')->all();

		if($array == true)
			return \yii\helpers\ArrayHelper::map($model, 'page_id', 'name_i');

		return $model;
	}

	/**
	 * function getMediaShow
	 */
	public static function getMediaShow($value=null)
	{
		$items = array(
			'1' => Yii::t('app', 'Show'),
			'0' => Yii::t('app', 'Hide'),
		);

		if($value !== null)
			return $items[$value];
		else
			return $items;
	}

	/**
	 * function getMediaType
	 */
	public static function getMediaType($value=null)
	{
		$items = array(
			'1' => Yii::t('app', 'Large'),
			'0' => Yii::t('app', 'Medium'),
		);

		if($value !== null)
			return $items[$value];
		else
			return $items;
	}

	/**
	 * @param returnAlias set true jika ingin kembaliannya path alias atau false jika ingin string
	 * relative path. default true.
	 */
	public static function getUploadPath($returnAlias=true) 
	{
		return ($returnAlias ? Yii::getAlias('@webroot/public/main') : 'public/main');
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		$this->name_i = isset($this->title) ? $this->title->message : '';
		$this->desc_i = isset($this->description) ? $this->description->message : '';
		$this->quote_i = isset($this->quoteRltn) ? $this->quoteRltn->message : '';
		$this->old_media = $this->media;
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			$mediaFileType = ['bmp','gif','jpg','png'];
			$media = UploadedFile::getInstance($this, 'media');

			if($media instanceof UploadedFile && !$media->getHasError()) {
				if(!in_array(strtolower($media->getExtension()), $mediaFileType)) {
					$this->addError('media', Yii::t('app', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}', [
						'name'=>$media->name,
						'extensions'=>$this->formatFileType($mediaFileType, false),
					]));
				}
			} /* else {
				if($this->isNewRecord || (!$this->isNewRecord && $this->old_media == ''))
					$this->addError('media', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('media')]));
			} */

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
		$module = strtolower(Yii::$app->controller->module->id);
		$controller = strtolower(Yii::$app->controller->id);
		$action = strtolower(Yii::$app->controller->action->id);

		$location = $this->urlTitle($controller);

		if(parent::beforeSave($insert)) {
			if(!$insert) {
				$uploadPath = self::getUploadPath();
				$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);
				$this->createUploadDirectory(self::getUploadPath());

				$this->media = UploadedFile::getInstance($this, 'media');
				if($this->media instanceof UploadedFile && !$this->media->getHasError()) {
					$fileName = join('-', [time(), UuidHelper::uuid(), $this->page_id]).'.'.strtolower($this->media->getExtension()); 
					if($this->media->saveAs(join('/', [$uploadPath, $fileName]))) {
						if($this->old_media != '' && file_exists(join('/', [$uploadPath, $this->old_media])))
							rename(join('/', [$uploadPath, $this->old_media]), join('/', [$verwijderenPath, time().'_change_'.$this->old_media]));
						$this->media = $fileName;
					}
				} else {
					if($this->media == '')
						$this->media = $this->old_media;
				}

			}
			if($insert || (!$insert && !$this->name)) {
				$name = new SourceMessage();
				$name->location = $location.'_title';
				$name->message = $this->name_i;
				if($name->save())
					$this->name = $name->id;

				$this->slug = $this->urlTitle($this->name_i);

			} else {
				$name = SourceMessage::findOne($this->name);
				$name->message = $this->name_i;
				$name->save();
			}

			if($insert || (!$insert && !$this->desc)) {
				$desc = new SourceMessage();
				$desc->location = $location.'_description';
				$desc->message = $this->desc_i;
				if($desc->save())
					$this->desc = $desc->id;

			} else {
				$desc = SourceMessage::findOne($this->desc);
				$desc->message = $this->desc_i;
				$desc->save();
			}

			if($insert || (!$insert && !$this->quote)) {
				$quote = new SourceMessage();
				$quote->location = $location.'_quote';
				$quote->message = $this->quote_i;
				if($quote->save())
					$this->quote = $quote->id;

			} else {
				$quote = SourceMessage::findOne($this->quote);
				$quote->message = $this->quote_i;
				$quote->save();
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

		$uploadPath = self::getUploadPath();
		$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);
		$this->createUploadDirectory(self::getUploadPath());

		if($insert) {
			$this->media = UploadedFile::getInstance($this, 'media');
			if($this->media instanceof UploadedFile && !$this->media->getHasError()) {
				$fileName = join('-', [time(), UuidHelper::uuid(), $this->page_id]).'.'.strtolower($this->media->getExtension()); 
				if($this->media->saveAs(join('/', [$uploadPath, $fileName])))
					self::updateAll(['media' => $fileName], ['page_id' => $this->page_id]);
			}

		}
	}

	/**
	 * After delete attributes
	 */
	public function afterDelete()
	{
		parent::afterDelete();

		$uploadPath = self::getUploadPath();
		$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);

		if($this->media != '' && file_exists(join('/', [$uploadPath, $this->media])))
			rename(join('/', [$uploadPath, $this->media]), join('/', [$verwijderenPath, time().'_deleted_'.$this->media]));

	}
}
