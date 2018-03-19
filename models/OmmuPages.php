<?php
/**
 * OmmuPages
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @modified date 20 January 2018, 06:30 WIB
 * @link https://github.com/ommu/ommu-core
 *
 * This is the model class for table "ommu_core_pages".
 *
 * The followings are the available columns in table 'ommu_core_pages':
 * @property integer $page_id
 * @property integer $publish
 * @property string $name
 * @property string $desc
 * @property integer $quote
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
 * @property Users $creation;
 * @property Users $modified;
 */

class OmmuPages extends OActiveRecord
{
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
				'class'=>'ext.yii-behavior-sluggable.SluggableBehavior',
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
			array('name_i', 'length', 'max'=>64),
			array('quote_i', 'length', 'max'=>128),
			array('media, quote_i, old_media_i', 'safe'),
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
			'quote_r' => array(self::BELONGS_TO, 'SourceMessage', 'quote'),
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
			'quote_r' => array(
				'alias'=>'quote_r',
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
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00', '1970-01-01 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		$criteria->compare('t.creation_id', Yii::app()->getRequest()->getParam('creation') ? Yii::app()->getRequest()->getParam('creation') : $this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00', '1970-01-01 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id', Yii::app()->getRequest()->getParam('modified') ? Yii::app()->getRequest()->getParam('modified') : $this->modified_id);
		if($this->updated_date != null && !in_array($this->updated_date, array('0000-00-00 00:00:00', '1970-01-01 00:00:00')))
			$criteria->compare('date(t.updated_date)', date('Y-m-d', strtotime($this->updated_date)));
		$criteria->compare('t.slug', strtolower($this->slug), true);

		$criteria->compare('title.message', strtolower($this->name_i), true);
		$criteria->compare('description.message', strtolower($this->desc_i), true);
		$criteria->compare('quote_r.message', strtolower($this->quote_i), true);
		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);
		$criteria->compare('view.views',$this->view_search);

		if(!Yii::app()->getRequest()->getParam('OmmuPages_sort'))
			$criteria->order = 't.page_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['grid-view'] ? Yii::app()->params['grid-view']['pageSize'] : 20,
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
				'value' => '$data->description->message',
			);
			$this->templateColumns['media'] = array(
				'name' => 'media',
				'value' => '$data->media',
			);
			$this->templateColumns['view_search'] = array(
				'name' => 'view_search',
				'value' => 'CHtml::link($data->view->views ? $data->view->views : 0, Yii::app()->createUrl("view/manage",array(\'page\'=>$data->page_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			if(!Yii::app()->getRequest()->getParam('creation')) {
				$this->templateColumns['creation_search'] = array(
					'name' => 'creation_search',
					'value' => '$data->creation->displayname ? $data->creation->displayname : \'-\'',
				);
			}
			$this->templateColumns['creation_date'] = array(
				'name' => 'creation_date',
				'value' => '!in_array($data->creation_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\')) ? Utility::dateFormat($data->creation_date) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => 'native-datepicker',
				/*
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'creation_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'creation_date_filter',
						'on_datepicker' => 'on',
						'placeholder' => Yii::t('phrase', 'filter'),
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
				*/
			);
			$this->templateColumns['modified_date'] = array(
				'name' => 'modified_date',
				'value' => '!in_array($data->modified_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\')) ? Utility::dateFormat($data->modified_date) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => 'native-datepicker',
				/*
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'modified_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'modified_date_filter',
						'on_datepicker' => 'on',
						'placeholder' => Yii::t('phrase', 'filter'),
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
				*/
			);
			if(!Yii::app()->getRequest()->getParam('modified')) {
				$this->templateColumns['modified_search'] = array(
					'name' => 'modified_search',
					'value' => '$data->modified->displayname ? $data->modified->displayname : \'-\'',
				);
			}
			$this->templateColumns['updated_date'] = array(
				'name' => 'updated_date',
				'value' => '!in_array($data->updated_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\')) ? Utility::dateFormat($data->updated_date) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => 'native-datepicker',
				/*
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'updated_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'updated_date_filter',
						'on_datepicker' => 'on',
						'placeholder' => Yii::t('phrase', 'filter'),
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
				*/
			);
			$this->templateColumns['slug'] = array(
				'name' => 'slug',
				'value' => '$data->slug',
			);
			$this->templateColumns['media_show'] = array(
				'name' => 'media_show',
				'value' => '$data->media_show == 1 ? CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/publish.png\') : CHtml::image(Yii::app()->theme->baseUrl.\'/images/icons/unpublish.png\')',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter'=>array(
					1=>Yii::t('phrase', 'Yes'),
					0=>Yii::t('phrase', 'No'),
				),
				'type' => 'raw',
			);
			$this->templateColumns['media_type'] = array(
				'name' => 'media_type',
				'value' => '$data->page_id == 1 ? Yii::t(\'phrase\', \'Large\') : Yii::t(\'phrase\', \'Medium\')',
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
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'publish\',array(\'id\'=>$data->page_id)), $data->publish)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Yii::t('phrase', 'Yes'),
						0=>Yii::t('phrase', 'No'),
					),
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
			$model = self::model()->findByPk($id,array(
				'select' => $column
			));
			return $model->$column;
			
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
	public static function getPages($publish=null, $type=null) 
	{
		$criteria=new CDbCriteria;
		if($publish != null)
			$criteria->compare('t.publish', $publish);

		$model = self::model()->findAll($criteria);

		if($type == null) {
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
		$this->quote_i = $this->quote_r->message;
		
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
			
			$media = CUploadedFile::getInstance($this, 'media');
			if($media->name != '') {
				$extension = pathinfo($media->name, PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), array('bmp','gif','jpg','png')))
					$this->addError('media', 'The file $media_name cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.', array('$media_name'=>$media->name));
			}
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() 
	{
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);

		$location = $controller;
		
		if(parent::beforeSave()) {
			$page_path = "public/page";
			// Add directory
			if(!file_exists($page_path)) {
				@mkdir($page_path, 0755,true);

				// Add file in directory (index.php)
				$newFile = $page_path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			} else
				@chmod($page_path, 0755,true);
			
			if($this->isNewRecord || (!$this->isNewRecord && !$this->name)) {
				$name=new SourceMessage;
				$name->message = $this->name_i;
				$name->location = $location.'_title';
				if($name->save())
					$this->name = $name->id;

				$this->slug = Utility::getUrlTitle($this->name_i);
				
			} else {
				$name = SourceMessage::model()->findByPk($this->name);
				$name->message = $this->name_i;
				$name->save();
			}

			if($this->isNewRecord || (!$this->isNewRecord && !$this->desc)) {
				$desc=new SourceMessage;
				$desc->message = $this->desc_i;
				$desc->location = $location.'_desc';
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

			//upload new photo
			if(in_array($action, array('add','edit'))) 
			{
				$this->media = CUploadedFile::getInstance($this, 'media');
				if($this->media instanceOf CUploadedFile) {
					$fileName = time().'_'.Utility::getUrlTitle($this->title->message).'.'.strtolower($this->media->extensionName);
					if($this->media->saveAs($page_path.'/'.$fileName)) {
						//create thumb image
						Yii::import('ext.phpthumb.PhpThumbFactory');
						$pageImg = PhpThumbFactory::create($page_path.'/'.$fileName, array('jpegQuality' => 90, 'correctPermissions' => true));
						$pageImg->resize(700);
						if($pageImg->save($page_path.'/'.$fileName)) {
							$this->media_show = 1;
							$this->media_type = 1;
						}
						
						if(!$this->isNewRecord && $this->old_media_i != '' && file_exists($page_path.'/'.$this->old_media_i))
							rename($page_path.'/'.$this->old_media_i, 'public/page/verwijderen/'.$this->page_id.'_'.$this->old_media_i);
						$this->media = $fileName;
					}
				}
				
				if(!$this->isNewRecord && $this->media == '')
					$this->media = $this->old_media_i;
			}
		}
		return true;
	}

	/**
	 * After delete attributes
	 */
	protected function afterDelete() 
	{
		parent::afterDelete();
		//delete page image
		$page_path = "public/page";
		if($this->media != '' && file_exists($page_path.'/'.$this->media)) {
			rename($page_path.'/'.$this->media, 'public/page/verwijderen/'.$this->page_id.'_'.$this->media);
		}
	}

}