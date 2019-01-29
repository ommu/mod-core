<?php
/**
 * CorePages
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 2 October 2017, 16:08 WIB
 * @modified date 16 April 2018, 16:16 WIB
 * @modified by Putra Sudaryanto <putra@sudaryanto.id>
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
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\behaviors\SluggableBehavior;
use app\models\SourceMessage;
use ommu\users\models\Users;
use ommu\core\models\view\CorePages as CorePagesView;

class CorePages extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;
	use \ommu\traits\FileTrait;

	public $gridForbiddenColumn = ['desc_i', 'quote_i', 'media', 'media_show', 'media_type', 'modified_date', 'modified_search', 'updated_date', 'slug'];
	public $name_i;
	public $desc_i;
	public $quote_i;
	public $old_media_i;

	// Search Variable
	public $creation_search;
	public $modified_search;
	public $view_search;
	public $media_search;

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
			[['name_i', 'desc_i', 'quote_i', 'media', 'slug', 'old_media_i'], 'string'],
			[['media', 'quote_i', 'creation_date', 'modified_date', 'updated_date', 'old_media_i'], 'safe'],
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
			'old_media_i' => Yii::t('app', 'Old Media'),
			'creation_search' => Yii::t('app', 'Creation'),
			'modified_search' => Yii::t('app', 'Modified'),
			'view_search' => Yii::t('app', 'Views'),
			'media_search' => Yii::t('app', 'Media'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getViews()
	{
		return $this->hasMany(CorePageViews::className(), ['page_id' => 'page_id']);
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
				return isset($model->title) ? $model->title->message : '-';
			},
		];
		$this->templateColumns['desc_i'] = [
			'attribute' => 'desc_i',
			'value' => function($model, $key, $index, $column) {
				return isset($model->description) ? $model->description->message : '-';
			},
			'format' => 'html',
		];
		$this->templateColumns['quote_i'] = [
			'attribute' => 'quote_i',
			'value' => function($model, $key, $index, $column) {
				return isset($model->quoteRltn) ? $model->quoteRltn->message : '-';
			},
		];
		$this->templateColumns['media'] = [
			'attribute' => 'media',
			'value' => function($model, $key, $index, $column) {
				return $model->media;
			},
		];
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'filter' => Html::input('date', 'creation_date', Yii::$app->request->get('creation_date'), ['class'=>'form-control']),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->creation_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->creation_date, 'datetime') : '-';
			},
			'format' => 'html',
		];
		if(!Yii::$app->request->get('creation')) {
			$this->templateColumns['creation_search'] = [
				'attribute' => 'creation_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->creation) ? $model->creation->displayname : '-';
				},
			];
		}
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'filter' => Html::input('date', 'modified_date', Yii::$app->request->get('modified_date'), ['class'=>'form-control']),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->modified_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->modified_date, 'datetime') : '-';
			},
			'format' => 'html',
		];
		if(!Yii::$app->request->get('modified')) {
			$this->templateColumns['modified_search'] = [
				'attribute' => 'modified_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->modified) ? $model->modified->displayname : '-';
				},
			];
		}
		$this->templateColumns['updated_date'] = [
			'attribute' => 'updated_date',
			'filter' => Html::input('date', 'updated_date', Yii::$app->request->get('updated_date'), ['class'=>'form-control']),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->updated_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->updated_date, 'datetime') : '-';
			},
			'format' => 'html',
		];
		$this->templateColumns['slug'] = [
			'attribute' => 'slug',
			'value' => function($model, $key, $index, $column) {
				return $model->slug;
			},
		];
		$this->templateColumns['media_show'] = [
			'attribute' => 'media_show',
			'filter' => $this->filterYesNo(),
			'value' => function($model, $key, $index, $column) {
				return $model->media_show ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['media_type'] = [
			'attribute' => 'media_type',
			'filter' => $this->filterYesNo(),
			'value' => function($model, $key, $index, $column) {
				return $model->media_show ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['media_search'] = [
			'attribute' => 'media_search',
			'filter' => $this->filterYesNo(),
			'value' => function($model, $key, $index, $column) {
				return $model->view->media ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['view_search'] = [
			'attribute' => 'view_search',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['page-view/index', 'page'=>$model->primaryKey]);
				return Html::a($model->view->views, $url);
			},
			'contentOptions' => ['class'=>'center'],
			'format'	=> 'html',
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
	 * function getPages
	 */
	public static function getPage($publish=null, $array=true) 
	{
		$model = self::find()->alias('t');
		$model->with(['title title']);
		if($publish != null)
			$model = $model->andWhere(['t.publish' => $publish]);

		$model = $model->orderBy('title.message ASC')->all();

		if($array == true) {
			$items = [];
			if($model !== null) {
				foreach($model as $val) {
					$items[$val->page_id] = $val->title->message;
				}
				return $items;
			} else
				return false;
		} else 
			return $model;
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
		$this->name_i = isset($this->title) ? $this->title->message : '';
		$this->desc_i = isset($this->description) ? $this->description->message : '';
		$this->quote_i = isset($this->quoteRltn) ? $this->quoteRltn->message : '';
		$this->old_media_i = $this->media;
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate() 
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			else
				$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;

			$mediaFileType = ['bmp','gif','jpg','png'];
			$media = UploadedFile::getInstance($this, 'media');

			if($media instanceof UploadedFile && !$media->getHasError()) {
				if(!in_array(strtolower($media->getExtension()), $mediaFileType)) {
					$this->addError('media', Yii::t('app', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}', array(
						'{name}'=>$media->name,
						'{extensions}'=>$this->formatFileType($mediaFileType, false),
					)));
				}
			} /* else {
				//if($this->isNewRecord && $controller == 'o/media')
					$this->addError('media', Yii::t('app', '{attribute} cannot be blank.', array('{attribute}'=>$this->getAttributeLabel('media'))));
			} */
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
					$fileName = time().'_'.$this->page_id.'.'.strtolower($this->media->getExtension()); 
					if($this->media->saveAs(join('/', [$uploadPath, $fileName]))) {
						if($this->old_media_i != '' && file_exists(join('/', [$uploadPath, $this->old_media_i])))
							rename(join('/', [$uploadPath, $this->old_media_i]), join('/', [$verwijderenPath, time().'_change_'.$this->old_media_i]));
						$this->media = $fileName;
					}
				} else {
					if($this->media == '')
						$this->media = $this->old_media_i;
				}
			}

			if($insert || (!$insert && !$this->name)) {
				$name = new SourceMessage();
				$name->location = $location.'_title';
				$name->message = $this->name_i;
				if($name->save())
					$this->name = $name->id;
				
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
				$fileName = time().'_'.$this->page_id.'.'.strtolower($this->media->getExtension()); 
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
