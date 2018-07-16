<?php
/**
 * OmmuPages
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @modified date 20 January 2018, 06:30 WIB
 * @modified date 10 April 2018, 16:41 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_pages".
 *
 * The followings are the available columns in table 'ommu_core_pages':
 * @property integer $page_id
 * @property integer $publish
 * @property string $name
 * @property string $desc
 * @property string $quote
 * @property string $media
 * @property integer $media_show
 * @property integer $media_type
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 * @property string $updated_date
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property OmmuPageViews[] $views
 * @property Users $creation
 * @property Users $modified
 */

class OmmuPages extends OActiveRecord
{
	use UtilityTrait;
	use GridViewTrait;

	public $gridForbiddenColumn = array('desc_i','quote_i','media','modified_date','modified_search','updated_date','slug');
	public $name_i;
	public $desc_i;
	public $quote_i;
	public $old_media_i;

	// Variable Search
	public $creation_search;
	public $modified_search;
	public $view_search;

	/**
	 * Behaviors for this model
	 */
	public function behaviors() 
	{
		return array(
			'sluggable' => array(
				'class'=>'ext.yii-sluggable.SluggableBehavior',
				'columns' => array('title.message'),
				'unique' => true,
				'update' => true,
			),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OmmuPages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		preg_match("/dbname=([^;]+)/i", $this->dbConnection->connectionString, $matches);
		return $matches[1].'.ommu_core_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_i, desc_i', 'required'),
			array('publish, media_show, media_type', 'numerical', 'integerOnly'=>true),
			array('name, desc, quote, creation_id, modified_id', 'length', 'max'=>11),
			array('media, media_show, media_type, 
				quote_i, old_media_i', 'safe'),
			array('name_i', 'length', 'max'=>64),
			array('quote_i', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('page_id, publish, name, desc, quote, media, media_show, media_type, creation_date, creation_id, modified_date, modified_id, updated_date, slug,
				name_i, desc_i, quote_i, creation_search, modified_search, view_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'view' => array(self::BELONGS_TO, 'ViewPages', 'page_id'),
			'views' => array(self::HAS_MANY, 'OmmuPageViews', 'page_id'),
			'title' => array(self::BELONGS_TO, 'SourceMessage', 'name'),
			'description' => array(self::BELONGS_TO, 'SourceMessage', 'desc'),
			'quoteRltn' => array(self::BELONGS_TO, 'SourceMessage', 'quote'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'page_id' => Yii::t('attribute', 'Page'),
			'publish' => Yii::t('attribute', 'Publish'),
			'name' => Yii::t('attribute', 'Title'),
			'desc' => Yii::t('attribute', 'Page'),
			'quote' => Yii::t('attribute', 'Quote'),
			'media' => Yii::t('attribute', 'Media'),
			'media_show' => Yii::t('attribute', 'Media Show'),
			'media_type' => Yii::t('attribute', 'Media Type'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'updated_date' => Yii::t('attribute', 'Updated Date'),
			'slug' => Yii::t('attribute', 'Slug'),
			'name_i' => Yii::t('attribute', 'Title'),
			'desc_i' => Yii::t('attribute', 'Page'),
			'quote_i' => Yii::t('attribute', 'Quote'),
			'old_media_i' => Yii::t('attribute', 'Old Media'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
			'view_search' => Yii::t('attribute', 'Views'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		// Custom Search
		$criteria->with = array(
			'view' => array(
				'alias'=>'view',
			),
			'title' => array(
				'alias'=>'title',
				'select'=>'message',
			),
			'description' => array(
				'alias'=>'description',
				'select'=>'message',
			),
			'quoteRltn' => array(
				'alias'=>'quoteRltn',
				'select'=>'message',
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname',
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname',
			),
		);

		$criteria->compare('t.page_id', $this->page_id);
		if(Yii::app()->getRequest()->getParam('type') == 'publish')
			$criteria->compare('t.publish', 1);
		elseif(Yii::app()->getRequest()->getParam('type') == 'unpublish')
			$criteria->compare('t.publish', 0);
		elseif(Yii::app()->getRequest()->getParam('type') == 'trash')
			$criteria->compare('t.publish', 2);
		else {
			$criteria->addInCondition('t.publish', array(0,1));
			$criteria->compare('t.publish', $this->publish);
		}
		$criteria->compare('t.name', $this->name);
		$criteria->compare('t.desc', $this->desc);
		$criteria->compare('t.quote', $this->quote);
		$criteria->compare('t.media', strtolower($this->media), true);
		$criteria->compare('t.media_show', $this->media_show);
		$criteria->compare('t.media_type', $this->media_type);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id', Yii::app()->getRequest()->getParam('creation') ? Yii::app()->getRequest()->getParam('creation') : $this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id', Yii::app()->getRequest()->getParam('modified') ? Yii::app()->getRequest()->getParam('modified') : $this->modified_id);
		if($this->updated_date != null && !in_array($this->updated_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.updated_date)', date('Y-m-d', strtotime($this->updated_date)));
		$criteria->compare('t.slug', strtolower($this->slug), true);

		$criteria->compare('title.message', strtolower($this->name_i), true);
		$criteria->compare('description.message', strtolower($this->desc_i), true);
		$criteria->compare('quoteRltn.message', strtolower($this->quote_i), true);
		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);
		$criteria->compare('view.views', $this->view_search);

		if(!Yii::app()->getRequest()->getParam('OmmuPages_sort'))
			$criteria->order = 't.page_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['grid-view'] ? Yii::app()->params['grid-view']['pageSize'] : 50,
			),
		));
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->templateColumns) == 0) {
			$this->templateColumns['_option'] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			$this->templateColumns['_no'] = array(
				'header' => Yii::t('app', 'No'),
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			$this->templateColumns['name_i'] = array(
				'name' => 'name_i',
				'value' => '$data->title->message',
			);
			$this->templateColumns['desc_i'] = array(
				'name' => 'desc_i',
				'value' => '$data->description->message',
			);
			$this->templateColumns['quote_i'] = array(
				'name' => 'quote_i',
				'value' => '$data->quoteRltn->message',
			);
			$this->templateColumns['media'] = array(
				'name' => 'media',
				'value' => '$data->media ? CHtml::link($data->media, Yii::app()->request->baseUrl.\'/public/page/\'.$data->media, array(\'target\' => \'_blank\')) : \'-\'',
			);
			if(!Yii::app()->getRequest()->getParam('creation')) {
				$this->templateColumns['creation_search'] = array(
					'name' => 'creation_search',
					'value' => '$data->creation->displayname ? $data->creation->displayname : \'-\'',
				);
			}
			$this->templateColumns['creation_date'] = array(
				'name' => 'creation_date',
				'value' => '!in_array($data->creation_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\', \'0002-12-02 07:07:12\', \'-0001-11-30 00:00:00\')) ? Yii::app()->dateFormatter->formatDateTime($data->creation_date, \'medium\', false) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'creation_date'),
			);
			$this->templateColumns['modified_date'] = array(
				'name' => 'modified_date',
				'value' => '!in_array($data->modified_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\', \'0002-12-02 07:07:12\', \'-0001-11-30 00:00:00\')) ? Yii::app()->dateFormatter->formatDateTime($data->modified_date, \'medium\', false) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'modified_date'),
			);
			if(!Yii::app()->getRequest()->getParam('modified')) {
				$this->templateColumns['modified_search'] = array(
					'name' => 'modified_search',
					'value' => '$data->modified->displayname ? $data->modified->displayname : \'-\'',
				);
			}
			$this->templateColumns['updated_date'] = array(
				'name' => 'updated_date',
				'value' => '!in_array($data->updated_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\', \'0002-12-02 07:07:12\', \'-0001-11-30 00:00:00\')) ? Yii::app()->dateFormatter->formatDateTime($data->updated_date, \'medium\', false) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'updated_date'),
			);
			$this->templateColumns['slug'] = array(
				'name' => 'slug',
				'value' => '$data->slug',
			);
			$this->templateColumns['view_search'] = array(
				'name' => 'view_search',
				'value' => 'CHtml::link($data->view->views ? $data->view->views : 0, Yii::app()->createUrl("view/manage", array(\'page\'=>$data->page_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->templateColumns['media_show'] = array(
				'name' => 'media_show',
				'value' => '$data->media_show == 1 ? CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['media_type'] = array(
				'name' => 'media_type',
				'value' => '$data->media_type == 1 ? Yii::t(\'phrase\', \'Large\') : Yii::t(\'phrase\', \'Medium\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'Large'),
					2=>Yii::t('phrase', 'Medium'),
				),
				'type' => 'raw',
			);
			if(!Yii::app()->getRequest()->getParam('type')) {
				$this->templateColumns['publish'] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'publish\', array(\'id\'=>$data->page_id)), $data->publish)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter' => $this->filterYesNo(),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id, array(
				'select' => $column,
			));
 			if(count(explode(',', $column)) == 1)
 				return $model->$column;
 			else
 				return $model;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;
		}
	}

	/**
	 * getPages
	 * 0 = unpublish
	 * 1 = publish
	 */
	public static function getPages($publish=null, $array=true) 
	{
		$criteria=new CDbCriteria;
		if($publish != null)
			$criteria->compare('t.publish', $publish);

		$model = self::model()->findAll($criteria);

		if($array == true) {
			$items = array();
			if($model != null) {
				foreach($model as $key => $val) {
					$items[$val->page_id] = $val->name;
				}
				return $items;
			} else
				return false;
		} else
			return $model;
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	protected function afterFind()
	{
		$this->name_i = $this->title->message;
		$this->desc_i = $this->description->message;
		$this->quote_i = $this->quoteRltn->message;
		
		parent::afterFind();
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() 
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : null;
			else
				$this->modified_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : null;

			$mediaFileType = array('bmp','gif','jpg','png');
			$media = CUploadedFile::getInstance($this, 'media');
			if($media->name != null) {
				$extension = pathinfo($media->name, PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), $mediaFileType))
					$this->addError('media', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}', array(
						'{name}'=>$media->name,
						'{extensions}'=>Utility::formatFileType($mediaFileType, false),
					));
			}
		}
		return true;
	}

	/**
	 * before save attributes
	 */
	protected function beforeSave() 
	{
		$module = strtolower(Yii::app()->controller->module->id);
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);

		$location = $controller;
		
		if(parent::beforeSave()) {
			if(!$this->isNewRecord) {
				$page_path = 'public/page';
				$verwijderen_path = join('/', array($page_path, 'verwijderen'));
				// Add directory
				if(!file_exists($page_path) || !file_exists($verwijderen_path)) {
					@mkdir($page_path, 0755, true);
					@mkdir($verwijderen_path, 0755, true);

					// Add file in directory (index.php)
					$newFile = $page_path.'/index.php';
					$FileHandle = fopen($newFile, 'w');

					$newVerwijderenFile = $verwijderen_path.'/index.php';
					$FileHandle = fopen($newVerwijderenFile, 'w');
				} else {
					@chmod($page_path, 0755, true);
					@chmod($verwijderen_path, 0755, true);
				}

				$this->media = CUploadedFile::getInstance($this, 'media');
				if($this->media != null) {
					if($this->media instanceOf CUploadedFile) {
						$fileName = time().'_'.$this->page_id.'.'.strtolower($this->media->extensionName);
						if($this->media->saveAs($page_path.'/'.$fileName)) {
							//create thumb image
							Yii::import('ext.phpthumb.PhpThumbFactory');
							$pageImg = PhpThumbFactory::create($page_path.'/'.$fileName, array('jpegQuality' => 90, 'correctPermissions' => true));
							$pageImg->resize(700);
							$pageImg->save($page_path.'/'.$fileName);

							if($this->old_media_i != '' && file_exists($page_path.'/'.$this->old_media_i))
								rename($page_path.'/'.$this->old_media_i, 'public/page/verwijderen/'.$this->page_id.'_'.$this->old_media_i);
							$this->media = $fileName;
						}
					}
				} else {
					if($this->media == '')
						$this->media = $this->old_media_i;
				}
			}

			if($this->isNewRecord || (!$this->isNewRecord && !$this->name)) {
				$name=new SourceMessage;
				$name->message = $this->name_i;
				$name->location = $location.'_title';
				if($name->save())
					$this->name = $name->id;

				$this->slug = $this->urlTitle($this->name_i);
				
			} else {
				$name = SourceMessage::model()->findByPk($this->name);
				$name->message = $this->name_i;
				$name->save();
			}

			if($this->isNewRecord || (!$this->isNewRecord && !$this->desc)) {
				$desc=new SourceMessage;
				$desc->message = $this->desc_i;
				$desc->location = $location.'_description';
				if($desc->save())
					$this->desc = $desc->id;
				
			} else {
				$desc = SourceMessage::model()->findByPk($this->desc);
				$desc->message = $this->desc_i;
				$desc->save();
			}

			if($this->isNewRecord || (!$this->isNewRecord && !$this->quote)) {
				$quote=new SourceMessage;
				$quote->message = $this->quote_i;
				$quote->location = $location.'_quote';
				if($quote->save())
					$this->quote = $quote->id;
				
			} else {
				$quote = SourceMessage::model()->findByPk($this->quote);
				$quote->message = $this->quote_i;
				$quote->save();
			}

			// Create action
		}
		return true;
	}

	/**
	 * After save attributes
	 */
	protected function afterSave() 
	{
		parent::afterSave();

		$page_path = 'public/page';
		$verwijderen_path = join('/', array($page_path, 'verwijderen'));
		// Add directory
		if(!file_exists($page_path) || !file_exists($verwijderen_path)) {
			@mkdir($page_path, 0755, true);
			@mkdir($verwijderen_path, 0755,true);

			// Add file in directory (index.php)
			$newFile = $page_path.'/index.php';
			$FileHandle = fopen($newFile, 'w');
			
			$newVerwijderenFile = $verwijderen_path.'/index.php';
			$FileHandle = fopen($newVerwijderenFile, 'w');
		} else {
			@chmod($page_path, 0755, true);
			@chmod($verwijderen_path, 0755,true);
		}

		if($this->isNewRecord) {
			$this->media = CUploadedFile::getInstance($this, 'media');
			if($this->media != null) {
				if($this->media instanceOf CUploadedFile) {
					$fileName = time().'_'.$this->page_id.'.'.strtolower($this->media->extensionName);
					if($this->media->saveAs($page_path.'/'.$fileName)) {
						//create thumb image
						Yii::import('ext.phpthumb.PhpThumbFactory');
						$pageImg = PhpThumbFactory::create($page_path.'/'.$fileName, array('jpegQuality' => 90, 'correctPermissions' => true));
						$pageImg->resize(700);
						$pageImg->save($page_path.'/'.$fileName);

						self::model()->updateByPk($this->page_id, array('media'=>$fileName, 'media_show'=>1, 'media_type'=>1));
					}
				}
			}
		}
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() 
	{
		parent::afterDelete();
		
		//delete article image
		$page_path = 'public/page';

		if($this->media != '' && file_exists($page_path.'/'.$this->media))
			rename($page_path.'/'.$this->media, 'public/page/verwijderen/'.$this->page_id.'_'.$this->media);
	}
}