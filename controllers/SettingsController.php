<?php
/**
 * SettingsController
 * @var $this SettingsController
 * @var $model OmmuSettings
 * @var $form CActiveForm
 *
 * Reference start
 * TOC :
 *	Index
 *	General
 *	Banned
 *	Signup
 *	Analytic
 *	Locale
 *	Manual
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 *----------------------------------------------------------------------------------------------------------
 */

class SettingsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize admin page theme
	 */
	public function init() 
	{
		if(!Yii::app()->user->isGuest) {
			if(in_array(Yii::app()->user->level, array(1,2))) {
				$arrThemes = $this->currentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
				$this->applyViewPath(__dir__, false);
			}
		} else
			$this->redirect(Yii::app()->createUrl('site/login'));
	}

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('general','banned','signup','analytic','locale'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->level == 1',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','manual'),
				'users'=>array('@'),
				'expression'=>'in_array(Yii::app()->user->level, array(1,2))',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->redirect(array('general'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionGeneral() 
	{
		if(Yii::app()->user->level != 1)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		
		$model = OmmuSettings::model()->findByPk(1);
		if($model == null)
			$model=new OmmuSettings;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuSettings'])) {
			$model->attributes=$_POST['OmmuSettings'];
			$model->scenario = 'general';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				$errors = $model->getErrors();
				$summary['msg'] = "<div class='errorSummary'><strong>".Yii::t('phrase', 'Please fix the following input errors:')."</strong>";
				$summary['msg'] .= "<ul>";
				foreach($errors as $key => $value) {
					$summary['msg'] .= "<li>{$value[0]}</li>";
				}
				$summary['msg'] .= "</ul></div>";

				$message = json_decode($jsonError, true);
				$merge = array_merge_recursive($summary, $message);
				$encode = json_encode($merge);
				echo $encode;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 0,
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'General settings success updated.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->pageTitle = Yii::t('phrase', 'General Settings');
		$this->pageDescription = Yii::t('phrase', 'This page contains general settings that affect your entire social network.');
		$this->pageMeta = '';
		$this->render('admin_general', array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionBanned() 
	{
		if(Yii::app()->user->level != 1)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		
		$model = OmmuSettings::model()->findByPk(1);
		if($model == null)
			$model=new OmmuSettings;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuSettings'])) {
			$model->attributes=$_POST['OmmuSettings'];
			$model->scenario = 'banned';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				$errors = $model->getErrors();
				$summary['msg'] = "<div class='errorSummary'><strong>".Yii::t('phrase', 'Please fix the following input errors:')."</strong>";
				$summary['msg'] .= "<ul>";
				foreach($errors as $key => $value) {
					$summary['msg'] .= "<li>{$value[0]}</li>";
				}
				$summary['msg'] .= "</ul></div>";

				$message = json_decode($jsonError, true);
				$merge = array_merge_recursive($summary, $message);
				$encode = json_encode($merge);
				echo $encode;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 0,
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Spam and banning tools success updated.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->pageTitle = Yii::t('phrase', 'Spam & Banning Tools');
		$this->pageDescription = Yii::t('phrase', 'Social networks are often the target of aggressive spam tactics. This most often comes in the form of fake user accounts and spam in comments. On this page, you can manage various anti-spam and censorship features. Note: To turn on the signup image verification feature (a popular anti-spam tool), see the {setting} page.', array(
			'{setting}' => CHtml::link(Yii::t('phrase', 'Signup Settings'), Yii::app()->createUrl('settings/signup')),
		));
		$this->pageMeta = '';
		$this->render('admin_banned', array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSignup() 
	{
		if(Yii::app()->user->level != 1)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		
		$model = OmmuSettings::model()->findByPk(1);
		if($model == null)
			$model=new OmmuSettings;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuSettings'])) {
			$model->attributes=$_POST['OmmuSettings'];
			$model->scenario = 'signup';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				$errors = $model->getErrors();
				$summary['msg'] = "<div class='errorSummary'><strong>".Yii::t('phrase', 'Please fix the following input errors:')."</strong>";
				$summary['msg'] .= "<ul>";
				foreach($errors as $key => $value) {
					$summary['msg'] .= "<li>{$value[0]}</li>";
				}
				$summary['msg'] .= "</ul></div>";

				$message = json_decode($jsonError, true);
				$merge = array_merge_recursive($summary, $message);
				$encode = json_encode($merge);
				echo $encode;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 0,
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Signup setting success updated.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->pageTitle = Yii::t('phrase', 'Signup Settings');
		$this->pageDescription = Yii::t('phrase', 'The user signup process is a crucial element of your social network. You need to design a signup process that is user friendly but also gets the initial information you need from new users. On this page, you can configure your signup process.');
		$this->pageMeta = '';
		$this->render('admin_signup', array(
			'model'=>$model,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAnalytic() 
	{
		if(Yii::app()->user->level != 1)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		
		$model = OmmuSettings::model()->findByPk(1);
		if($model == null)
			$model=new OmmuSettings;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuSettings'])) {
			$model->attributes=$_POST['OmmuSettings'];
			$model->scenario = 'analytic';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				$errors = $model->getErrors();
				$summary['msg'] = "<div class='errorSummary'><strong>".Yii::t('phrase', 'Please fix the following input errors:')."</strong>";
				$summary['msg'] .= "<ul>";
				foreach($errors as $key => $value) {
					$summary['msg'] .= "<li>{$value[0]}</li>";
				}
				$summary['msg'] .= "</ul></div>";

				$message = json_decode($jsonError, true);
				$merge = array_merge_recursive($summary, $message);
				$encode = json_encode($merge);
				echo $encode;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 0,
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Google analytics setting success updated.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->pageTitle = Yii::t('phrase', 'Google Analytics Settings');
		$this->pageDescription = Yii::t('phrase', 'Want to use Google Analytics to keep track of your site\'s traffic data? Setup is super easy. Just enter your Google Analytics Tracking ID and *bam*... you\'re tracking your site\'s traffic stats! If you need help finding your ID, check here.');
		$this->pageMeta = '';
		$this->render('admin_analytic', array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionLocale() 
	{
		if(Yii::app()->user->level != 1)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		
		$model = OmmuSettings::model()->findByPk(1);
		if($model == null)
			$model=new OmmuSettings;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuSettings'])) {
			$model->attributes=$_POST['OmmuSettings'];
			$model->scenario = 'locale';

			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				$errors = $model->getErrors();
				$summary['msg'] = "<div class='errorSummary'><strong>".Yii::t('phrase', 'Please fix the following input errors:')."</strong>";
				$summary['msg'] .= "<ul>";
				foreach($errors as $key => $value) {
					$summary['msg'] .= "<li>{$value[0]}</li>";
				}
				$summary['msg'] .= "</ul></div>";

				$message = json_decode($jsonError, true);
				$merge = array_merge_recursive($summary, $message);
				$encode = json_encode($merge);
				echo $encode;
				
			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 0,
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Locale setting success updated.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->pageTitle = Yii::t('phrase', 'Locale Settings');
		$this->pageDescription = Yii::t('phrase', 'Please select a default timezone setting for your social network. This will be the default timezone applied to users\' accounts if they do not select a timezone during signup, or if they are not signed in. Select the default locale you want to use on your social network. This will affect the language of the dates that appear on your social network pages.');
		$this->pageMeta = '';
		$this->render('admin_locale', array(
			'model'=>$model,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionManual() 
	{
		$manual_path = YiiBase::getPathOfAlias('application.ommu.assets.manual');
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('admin/dashboard');
		$this->dialogWidth = 400;
		
		$this->pageTitle = Yii::t('phrase', 'Core Manual');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manual', array(
			'manual_path'=>$manual_path,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = OmmuSettings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ommu-settings-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
