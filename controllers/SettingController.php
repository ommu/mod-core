<?php
/**
 * SettingController
 * @var $this ommu\core\controllers\SettingController
 * @var $model ommu\core\models\CoreSettings
 *
 * SettingController implements the CRUD actions for CoreSettings model.
 * Reference start
 * TOC :
 *	Index
 *	General
 *	Banned
 *	Signup
 *	Language
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 2 October 2017, 01:10 WIB
 * @modified date 23 April 2018, 18:49 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\controllers;

use Yii;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use yii\filters\VerbFilter;
use ommu\core\models\CoreSettings;
use ommu\core\models\search\CoreLanguages as CoreLanguagesSearch;
use ommu\core\models\CoreLanguages;
use yii\helpers\Html;
use yii\helpers\Url;

class SettingController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
        return [
            'access' => [
                'class' => AccessControl::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
	}

	/**
	 * Lists all CoreSettings models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->redirect(['general']);
	}

	/**
	 * Creates a new CoreSettings model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionGeneral()
	{
		$model = CoreSettings::findOne(1);
        if ($model === null) {
            $model = new CoreSettings();
        }
		$model->scenario = CoreSettings::SCENARIO_GENERAL;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // $postData = Yii::$app->request->post();
            // $model->load($postData);
            // $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Public permissions success updated.'));
                return $this->redirect(['general']);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }

		$this->view->title = Yii::t('app', 'Public Permissions');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_general', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new CoreSettings model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionBanned()
	{
		$model = CoreSettings::findOne(1);
        if ($model === null) {
            $model = new CoreSettings();
        }
		$model->scenario = CoreSettings::SCENARIO_BANNED;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // $postData = Yii::$app->request->post();
            // $model->load($postData);
            // $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Spam & banning setting success updated.'));
                return $this->redirect(['banned']);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }
		
		$this->view->title = Yii::t('app', 'Spam & Banning Tools');
		$this->view->description = Yii::t('app', '{app-name} platform are often the target of aggressive spam tactics. This most often comes in the form of fake user accounts and spam in comments. On this page, you can manage various anti-spam and censorship features. Note: To turn on the signup image verification feature (a popular anti-spam tool), see the {setting} page.', ['app-name' => Yii::$app->name, 'setting' => Html::a(Yii::t('app', 'Signup Setting'), Url::to(['signup']))]);
		$this->view->keywords = '';
		return $this->render('admin_banned', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new CoreSettings model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionSignup()
	{
		$model = CoreSettings::findOne(1);
        if ($model === null) {
            $model = new CoreSettings();
        }
		$model->scenario = CoreSettings::SCENARIO_SIGNUP;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // $postData = Yii::$app->request->post();
            // $model->load($postData);
            // $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Signup setting success updated.'));
                return $this->redirect(['signup']);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }

		$this->view->title = Yii::t('app', 'Signup Settings');
		$this->view->description = Yii::t('app', 'The user signup process is a crucial element of your {app-name} platform. You need to design a signup process that is user friendly but also gets the initial information you need from new users. On this page, you can configure your signup process.', ['app-name' => Yii::$app->name]);
		$this->view->keywords = '';
		return $this->render('admin_signup', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new CoreSettings model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionLanguage()
	{
		$model = CoreSettings::findOne(1);
        if ($model === null) {
            $model = new CoreSettings();
        }
		$model->scenario = CoreSettings::SCENARIO_LANGUAGE;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // $postData = Yii::$app->request->post();
            // $model->load($postData);
            // $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Language setting success updated.'));
                return $this->redirect(['language']);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }

		$this->subMenu = $this->module->params['language_submenu'];
		$this->view->title = Yii::t('app', 'Language Settings');
		$this->view->description = Yii::t('app', 'The layout of your {app-name} platform includes hundreds of apps of text which are stored in a language pack. {app-name} platform comes with an English pack which is the default when you first install the platform. If you want to change any of these apps on your {app-name} platform, you can edit the pack below. If you want to allow users to pick from multiple languages, you can also create additional packs below. If you have multiple language packs, the pack you\'ve selected as your "default" will be the language that displays if a user has not selected any other language. Note: You can not delete the default language. To edit a language\'s details, click its name.', ['app-name' => Yii::$app->name]);
		$this->view->keywords = '';
		return $this->render('admin_language', [
			'model' => $model,
		]);
	}

	/**
	 * Finds the CoreSettings model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CoreSettings the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
        if (($model = CoreSettings::findOne($id)) !== null) {
            return $model;
        }

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
