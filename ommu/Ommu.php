<?php
/**
 * Ommu class file
 * Bootstrap application
 * in this class you set default controller to be executed first time
 *
 * Reference start
 * TOC :
 *	init
 *	getDefaultTheme
 *	getRulePos
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @create date August 6, 2012 15:02 WIB
 * @updated date February 20, 2014 15:50 WIB
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 *----------------------------------------------------------------------------------------------------------
 */

Yii::import('application.vendor.mustangostang.spyc.Spyc');
define('DS', DIRECTORY_SEPARATOR);

class Ommu extends CApplicationComponent
{
	/**
	 * Initialize
	 *
	 * load some custom components here, for example
	 * theme, url manager, or config from database Alhamdulillah :)
	 */
	public function init() 
	{
		//register vendor namespace
		$vendor_path = Yii::getPathOfAlias('application.vendor');
		foreach (new DirectoryIterator($vendor_path) as $fileInfo) {
			if($fileInfo->isDot())
				continue;
			
			if($fileInfo->isDir() && !in_array($fileInfo->getFilename(), array('bin','composer')))
				Yii::setPathOfAlias($fileInfo->getFilename(), $vendor_path.'/'.$fileInfo->getFilename());
		}
		//$this->setAlias($vendor_path);
		//register theme namespace
		$theme_path = Yii::getPathOfAlias('webroot.themes');
		$this->setAlias($theme_path, true);
		
		/**
		 * set default themes
		 */
		$theme = $this->getDefaultTheme();
		if(Yii::app()->getRequest()->getParam('theme')) {
			$theme = trim(Yii::app()->getRequest()->getParam('theme'));
		}
		//Yii::app()->theme = $theme;
		
		/**
		 * controllerMap
		 */
		$controllerMap = array();
		// controllerMap for themes
		$publicTheme = $this->getDefaultTheme();
		if($publicTheme)
			$controllerMap = $this->getThemeController($publicTheme);

		$maintenanceTheme = $this->getDefaultTheme('maintenance');
		if($maintenanceTheme && $publicTheme != $maintenanceTheme) {
			if(!empty($controllerMap))
				$controllerMap = array_merge($controllerMap, $this->getThemeController($maintenanceTheme));
			else
				$controllerMap = $this->getThemeController($maintenanceTheme);
		}

		// controllerMap for core module
		$coreControllerPath = 'application.libraries.core.controllers';
		if(!empty($controllerMap))
			$controllerMap = array_merge($controllerMap, $this->getController($coreControllerPath));
		else
			$controllerMap = $this->getController($coreControllerPath);
		Yii::app()->controllerMap = $controllerMap;

		/**
		 * set url manager
		 */
		$rules = array(
			//a standard rule mapping '/' to 'site/index' action
			'' 																	=> 'site/index',
			
			//a standard rule mapping '/login' to 'site/login', and so on
			'<action:(login|logout)>' 											=> 'site/<action>',
			'<slug:[\w\-]+>-<id:\d+>'											=> 'page/view',
			//'<slug:[\w\-]+>'													=> 'page/view',
			// module condition
			'<module:\w+>/<controller:\w+>/<action:\w+>'						=> '<module>/<controller>/<action>',
			//controller condition
			'<controller:\w+>/<action:\w+>'										=> '<controller>/<action>',
		);

		/**
		 * Set default controller for homepage, it can be controller, action or module
		 * example:
		 * controller: 'site'
		 * controller from module: 'pose/site/index'.
		 */
		$default = OmmuPlugins::model()->findByAttributes(array('default' => 1), array(
			'select' => 'folder',
		));
		if($default == null || ($default != null && ($default->folder == '-' || $default->actived == '2'))) {
			$rules[''] = 'site/index';

		} else {
			$folder = $default->folder != '-' ? $default->folder : 'site/index';
			Yii::app()->defaultController = trim($folder);
			$rules[''] =  trim($folder);
		}

		/**
		 * Split rules into 2 part and then insert url from tabel between them.
		 * and then merge all array back to $rules.
		 */
		$module = OmmuPlugins::model()->findAll(array(
			'select'    => 'actived, folder, search',
			'condition' => 'actived = :actived',
			'params' => array(
				':actived' => '1',
			),
		));		

		$moduleRules  = array();
		$sliceRules   = $this->getRulePos($rules);
		if($module !== null) {
			foreach($module as $key => $val) {
				if($val->search == '1') {
$moduleRules[$val->folder] 																= $val->folder;
$moduleRules[$val->folder] 																= $val->folder.'/site/index';
$moduleRules[$val->folder.'/<slug:[\w\-]+>-<id:\d+>'] 									= $val->folder.'/site/view';								// slug-id
//$moduleRules[$val->folder.'/<slug:[\w\-]+>'] 											= $val->folder.'/site/view';								// slug
$moduleRules[$val->folder.'/<controller:[a-zA-Z\/]+>/<slug:[\w\-]+>-<id:\d+>'] 			= $val->folder.'/<controller>/view';						// slug-id
//$moduleRules[$val->folder.'/<controller:[a-zA-Z\/]+>/<slug:[\w\-]+>'] 					= $val->folder.'/<controller>/view';						// slug
$moduleRules[$val->folder.'/<controller:[a-zA-Z\/]+>/<category:\d+>/<slug:[\w\-]+>'] 	= $val->folder.'/<controller>/index';						// category/slug
//$moduleRules[$val->folder.'/<controller:[a-zA-Z\/]+>/<slug:[\w\-]+>'] 					= $val->folder.'/<controller>/index';						// slug
$moduleRules[$val->folder.'/<controller:[a-zA-Z\/]+>/<action:\w+>/<slug:[\w\-]+>-<id:\d+>'] 		= $val->folder.'/<controller>/<action>';		// slug-id
$moduleRules[$val->folder.'/<controller:[a-zA-Z\/]+>/<action:\w+>/<category:\d+>/<slug:[\w\-]+>'] 	= $val->folder.'/<controller>/<action>';		// category/slug
//$moduleRules[$val->folder.'/<controller:[a-zA-Z\/]+>/<action:\w+>/<slug:[\w\-]+>'] 					= $val->folder.'/<controller>/<action>';		// slug
				}
			}
		}
		$rules = array_merge($sliceRules['before'], $moduleRules, $sliceRules['after']);

		Yii::app()->setComponents(array(
			'urlManager' => array(
				'urlFormat' => 'path',
				'showScriptName' => false,
				'rules' => $rules,
			),
		));		

		Yii::setPathOfAlias('modules', Yii::app()->basePath.DIRECTORY_SEPARATOR.'modules');
		
		/**
		 * Registers meta tags declared
		 * google discoverability
		 * google plus
		 * facebook opengraph
		 * twitter
		 */
		$meta = OmmuMeta::model()->findByPk(1);
		$images = $meta->meta_image != '' ? $meta->meta_image : 'meta_default.png';
		$metaImages = Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->request->baseUrl.'/public/'.$images;
		
		$twitter_photo_size = unserialize($meta->twitter_photo_size);
		$twitter_iphone = unserialize($meta->twitter_iphone);
		if(empty($twitter_iphone))
			$twitter_iphone = array();
		$twitter_ipad = unserialize($meta->twitter_ipad);
		if(empty($twitter_ipad))
			$twitter_ipad = array();
		$twitter_googleplay = unserialize($meta->twitter_googleplay);
		if(empty($twitter_googleplay))
			$twitter_googleplay = array();
		
		// Google Discoverability mata tags
		$point = explode(',', $meta->office_location);
		
		// Facebook mata tags
		$arrayFacebookGlobal = array(
			'og:type'=>$meta->facebook_type == 1 ? 'profile' : 'website',
			'og:title'=>'MY_WEBSITE_NAME',
			'og:description'=>'MY_WEBSITE_DESCRIPTION',
			'og:image'=>$metaImages,
		);
		if($meta->facebook_sitename != '')
			$arrayFacebookGlobal['og:site_name'] = $meta->facebook_sitename;
		if($meta->facebook_see_also != '')
			$arrayFacebookGlobal['og:see_also'] = $meta->facebook_see_also;
		if($meta->facebook_admins != '')
			$arrayFacebookGlobal['fb:admins'] = $meta->facebook_admins;
		
		if($meta->facebook_type == 1) {
			$arrayFacebook = array(
				'profile:first_name'=>$meta->facebook_profile_firstname,
				'profile:last_name'=>$meta->facebook_profile_lastname,
				'profile:username'=>$meta->facebook_profile_username,
			);	
		} else
			$arrayFacebook = array();
		
		// Twitter mata tags
		if($meta->twitter_card == 1) {
			$cardType = 'summary';
			$arrayTwitter = array();
		} else if($meta->twitter_card == 2) {
			$cardType = 'summary_large_image';
			$arrayTwitter = array();
		} else if($meta->twitter_card == 3) {
			$cardType = 'photo';
			$arrayTwitter = array(
				'twitter:image:width'=>$twitter_photo_size['width'],
				'twitter:image:height'=>$twitter_photo_size['height'],
			);
		} else {
			$cardType = 'app';
			if($meta->twitter_country != '')
				$arrayTwitter['twitter:app:country'] = $meta->twitter_country;
			if(!empty($twitter_iphone) && $twitter_iphone['name'])
				$arrayTwitter['twitter:app:name:iphone'] = $twitter_iphone['name'];
			if(!empty($twitter_iphone) && $twitter_iphone['id'])
				$arrayTwitter['twitter:app:id:iphone'] = $twitter_iphone['id'];
			if(!empty($twitter_iphone) && $twitter_iphone['url'])
				$arrayTwitter['twitter:app:url:iphone'] = $twitter_iphone['url'];
			if(!empty($twitter_ipad) && $twitter_ipad['name'])
				$arrayTwitter['twitter:app:name:ipad'] = $twitter_ipad['name'];
			if(!empty($twitter_ipad) && $twitter_ipad['id'])
				$arrayTwitter['twitter:app:id:ipad'] = $twitter_ipad['id'];
			if(!empty($twitter_ipad) && $twitter_ipad['url'])
				$arrayTwitter['twitter:app:url:ipad'] = $twitter_ipad['url'];
			if(!empty($twitter_googleplay) && $twitter_googleplay['name'])
				$arrayTwitter['twitter:app:name:googleplay'] = $twitter_googleplay['name'];
			if(!empty($twitter_googleplay) && $twitter_googleplay['id'])
				$arrayTwitter['twitter:app:id:googleplay'] = $twitter_googleplay['id'];
			if(!empty($twitter_googleplay) && $twitter_googleplay['url'])
				$arrayTwitter['twitter:app:url:googleplay'] = $twitter_googleplay['url'];
			
			if(empty($arrayTwitter))
				$arrayTwitter = array();
		}
		$arrayTwitterGlobal = array(
			'twitter:card'=>$cardType,
			'twitter:site'=>$meta->twitter_site,
			'twitter:title'=>'MY_WEBSITE_NAME',
			'twitter:description'=>'MY_WEBSITE_DESCRIPTION',
			'twitter:image'=>$metaImages,
		);
		if(in_array($meta->twitter_card, array(2)))
			$arrayTwitterGlobal['twitter:creator'] = $meta->twitter_creator;
		if($meta->meta_image_alt != '' && in_array($meta->meta_image_alt, array(1,2)))
			$arrayTwitterGlobal['twitter:image:alt'] = $meta->meta_image_alt;
		
		/**
		 * Registe Meta Tags
		 */ 
		Yii::app()->setComponents(array(
			'meta'=>array(
				'class' => 'application.libraries.core.components.plugin.MetaTags',
				'googleOwnerTags'=>array(	// set default OG tags
					'place:location:latitude'=>$point[0],
					'place:location:longitude'=>$point[1],
					'business:contact_data:street_address'=>$meta->office_place.', '.$meta->office_village.', '.$meta->office_district,
					'business:contact_data:country_name'=>$meta->view->country_name,
					'business:contact_data:locality'=>$meta->view->city_name,
					'business:contact_data:region'=>$meta->office_district,
					'business:contact_data:postal_code'=>$meta->office_zipcode,
					'business:contact_data:email'=>$meta->office_email,
					'business:contact_data:phone_number'=>$meta->office_phone,
					'business:contact_data:fax_number'=>$meta->office_fax,
					'business:contact_data:website'=>$meta->office_website,
				),
				'googlePlusTags'=>array(	// set default OG tags
					'name'=>'MY_WEBSITE_NAME',
					'description'=>'MY_WEBSITE_DESCRIPTION',
					'image'=>$metaImages,
				),
				'facebookTags'=>CMap::mergeArray(
					$arrayFacebookGlobal,
					$arrayFacebook
				),
				'twitterTags'=>CMap::mergeArray(
					$arrayTwitterGlobal,
					$arrayTwitter
				),
			),
		));
	}

	/**
	 * Get default theme from database
	 *
	 * @return string theme name
	 */
	public function getDefaultTheme($type='public') 
	{
		$theme = OmmuThemes::model()->find(array(
			'select'    => 'folder',
			'condition' => 'group_page = :group AND default_theme = :default',
			'params'    => array(
				':group' => $type,
				':default' => '1',
			),
		));

		if($theme !== null)
			return $theme->folder;
		else
			return null;
	}

	/**
	 * Split rules into two part
	 *
	 * @param array $rules
	 * @return array
	 */
	public static function getRulePos($rules) {
		$result = 1;
		$before = array();
		$after  = array();

		foreach($rules as $key => $val) {
			if($key == '<module:\w+>/<controller:\w+>/<action:\w+>')
				break;
			$result++;
		}

		$i = 1;
		foreach($rules as $key => $val) {
			if($i < $result)
				$before[$key] = $val;
			elseif($i >= $pos)
				$after[$key]  = $val;
			$i++;
		}

		return array('after' => $after, 'before' => $before);
	}

	public function getController($path, $sub=null)
	{
		$controllerMap = array();
		$controllerPath = Yii::getPathOfAlias($path);
		$pathArray = explode('.', $path);
		$lastPath = end($pathArray);

		foreach (new DirectoryIterator($controllerPath) as $fileInfo) {
			if($fileInfo->isDot() && $fileInfo->isDir())
				continue;
			
			if($fileInfo->isFile() && !in_array($fileInfo->getFilename(), array('index.php','.DS_Store'))) {
				$getFilename = $fileInfo->getFilename();
				$controller = strtolower(preg_replace('(Controller.php)', '', $getFilename));
				if($lastPath != 'controllers')
					$controller = join('', array($lastPath, preg_replace('(Controller.php)', '', $getFilename)));
				$controllerClass = preg_replace('(.php)', '', $getFilename);

				$controllerMap[$controller] = array(
					'class'=>join('.', array($path, $controllerClass)),
				);

			} else if($fileInfo->isDir()) {
				$sub = $fileInfo->getFilename();
				$subPath = join('.', array($path, $sub));
				$controllerMap = array_merge($controllerMap, $this->getController($subPath, $sub));
			}
		}
		
		return $controllerMap;
	}

	public function getThemeController($theme)
	{
		if($theme) {
			$themeControllerPath = 'webroot.themes.'.$theme.'.controllers';
			if(file_exists(Yii::getPathOfAlias($themeControllerPath)))
				return $this->getController($themeControllerPath);
		} else
			return null;
	}

	public function setAlias($path, $theme=false)
	{
		foreach (new DirectoryIterator($path) as $fileInfo) {
			if($fileInfo->isDot())
				continue;
			
			$getFilename = $fileInfo->getFilename();
			if($fileInfo->isDir() && !in_array($getFilename, array('bin','composer'))) {
				Yii::setPathOfAlias(($theme == true && $getFilename != 'ommu') ? $getFilename : $getFilename.'theme', $path.'/'.$getFilename);
			}
		}
	}
}
