<?php
/**
 * ThemeHandle class file
 * Contains many function that most used
 *
 * Reference start
 * TOC :
 *	getIgnoreTheme
 *	getThemeFromDb
 *	getThemeFromDir
 *	cacheThemeConfig
 *	getThemeConfig
 *	deleteThemeFolder
 *	deleteTheme
 *	setThemes
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-core
 *
 *----------------------------------------------------------------------------------------------------------
 */

class ThemeHandle extends CApplicationComponent
{
	public $themePath        = 'webroot.themes';
	private $_themeTableName = 'ommu_core_themes';
	
	/**
	 * return ignore theme from scanner.
	 */
	public function getIgnoreTheme()
	{
		return array();
	}
	
	/*
	 Dapatkan total modul yang ada pada tabel modul.
	 @return integer rows.
	*/
	public function getThemeFromDb($default_theme=null)
	{
		$criteria = new CDbCriteria;
		if($default_theme != null)
			$criteria->compare('default_theme', $default_theme);
		$criteria->order = 'folder ASC';
		$themes = OmmuThemes::model()->findAll($criteria);
		
		return $themes;
	}

	/**
	 * Mendapatkan daftar theme dari folder themes.
	 *
	 * @return array daftar theme yang ada atau false jika tidak terdapat theme.
	 */
	public function getThemeFromDir()
	{
		$themeList = array();
		$themePath = Yii::getPathOfAlias('webroot.themes');
		$themes    = scandir($themePath);
		foreach($themes as $theme) {
			$themeName = Utility::getUrlTitle($theme);
			$themeFile = $themePath.'/'.$theme.'/'.$themeName.'.yaml';
			if(file_exists($themeFile)) {
				if(!in_array($themeName, $this->getIgnoreTheme())) {
					$themeList[] = $theme;
				}
			}
		}

		if(count($themeList) > 0)
			return $themeList;
		else
			return false;
	}
	
	/**
	 * Cache theme dari database ke bentuk file.
	 * Untuk mengurangi query pada saat install ke database.
	 */
	public function cacheThemeConfig($return=false)
	{
		$themes = $this->getThemeFromDb();
		$arrayTheme = array();

		foreach($themes as $theme) {
			if(!in_array($theme->folder, $arrayTheme))
				$arrayTheme[] = $theme->folder;
		}

		if($return == false) {
			$filePath   = Yii::getPathOfAlias('application.config');
			$fileHandle = fopen($filePath.'/cache_theme.php', 'w');
			fwrite($fileHandle, implode("\n", $arrayTheme));
			fclose($fileHandle);

		} else 
			return $arrayTheme;
	}

	/**
	 * Get theme config from yaml file
	 *
	 * @param string $theme
	 * @return array
	 */
	public function getThemeConfig($theme)
	{
		Yii::import('application.libraries.core.components.plugin.Spyc');
		define('DS', DIRECTORY_SEPARATOR);

		$themeName = Utility::getUrlTitle($theme);
		$configPath = Yii::getPathOfAlias('webroot.themes.'.$theme).DS.$themeName.'.yaml';

		if(file_exists($configPath))
			return Spyc::YAMLLoad($configPath);
		else
			return null;
	}
	
	/**
	 * Delete DB folder
	 */
	public function deleteThemeDb($theme)
	{
		if($theme != null) {
			$model = OmmuThemes::model()->findByAttributes(array('folder'=>$theme));
			
			if($model != null)
				$model->delete();
			else 
				return false;

		} else 
			return false;
	}
	
	/**
	 * Delete theme folder
	 */
	public function deleteThemeFolder($themePath)
	{
		// Sanity check
		if (file_exists($themePath)) {
			Utility::deleteFolder($themePath);
			//Utility::recursiveDelete($themePath);
			//echo $themePath;
			//exit();

		} else 
			return false;
	}

	/**
	 * Delete themes
	 */
	public function deleteTheme($theme=null, $db=false)
	{
		if($theme != null) {
			//Delete theme database
			if($db == true)
				$this->deleteThemeDb($theme);

			//Delete theme source
			$themePath = Yii::getPathOfAlias('webroot.themes.'.$theme);
			$this->deleteThemeFolder($themePath);

		} else 
			return false;
	}
	
	/**
	 * Install theme ke database
	 */
	public function setThemes()
	{
		$installedTheme	= $this->getThemeFromDir();
		$cacheTheme		= file(Yii::getPathOfAlias('application.config').'/cache_theme.php');
		$toBeInstalled    = array();
		
		$caches = array();
		foreach($cacheTheme as $val) {
			$caches[] = $val;
		}

		if(!$installedTheme)
			$installedTheme = array();
			
		foreach($caches as $cache) {
			if(!in_array(trim($cache), array_map("trim", $installedTheme))) {
				$this->deleteTheme($cache, true);
			}
		}

		$themeDb = $this->cacheThemeConfig(true);
		foreach($installedTheme as $theme) {
			if(!in_array(trim($theme), array_map("trim", $themeDb))) {
				$config = $this->getThemeConfig($theme);
				$themeName = Utility::getUrlTitle($theme);

				if($config && $themeName == $config['folder']) {
					$model=new OmmuThemes;
					$model->group_page = $config['group_page'];
					$model->folder = $theme;
					$model->layout = $config['layout'];
					$model->name = $config['name'];
					$model->thumbnail = $config['thumbnail'];
					$model->save();
				}
			}
		}
	}
}