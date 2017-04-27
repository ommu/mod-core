<?php

/**
 * OauthIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 * version: 1.2.0
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Core
 * @contact (+62)856-299-4114
 *
 */
class OauthIdentity extends OUserIdentity
{
	public $email;
	private $_id;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$oauthConnected = self::getOauthServerConnected();
		$url = $oauthConnected.'/users/api/oauth/login';
		
		$item = array(
			'email' => $this->username,
			'password' => $this->password,
			'access' => Yii::app()->params['product_access_system'],
			'ipaddress' => $_SERVER['REMOTE_ADDR'],
		);
		$items = http_build_query($item);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch,CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $items);
		$output=curl_exec($ch);
		
		if($output === false) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			
		} else {
			$object = json_decode($output);
			if($object->success == 1) {
				$user = Users::model()->findByAttributes(array('email'=>$object->email));
				if($user != null)
					$this->setUserSession($user);
				
				else {
					$model=new Users;
					$model->email = $object->email;
					$model->username = $object->username;
					$model->first_name = $object->first_name;
					$model->last_name = $object->last_name;
					$model->displayname = $object->displayname;
					if($model->save()) {
						$user = Users::model()->findByAttributes(array('email'=>$object->email));
						$this->setUserSession($user);				
					}
				}
				$this->errorCode = self::ERROR_NONE;
				
			} else {
				if($object->error == 'email')
					$this->errorCode = self::ERROR_USERNAME_INVALID;
				else if($object->error == 'password')
					$this->errorCode = self::ERROR_PASSWORD_INVALID;
			}
		}
		return !$this->errorCode;
	}

	public function getId() {
		return $this->_id;
	}

	//returns true, if domain is availible, false if not
	public function setUserSession($user) 
	{
		$this->_id = $user->user_id;
		$this->setState('level', $user->level_id);
		$this->setState('language', $user->language_id);
		$this->email = $user->email;
		$this->setState('username', $user->username);
		$this->setState('displayname', $user->displayname);
		$this->setState('creation_date', $user->creation_date);
		$this->setState('lastlogin_date', date('Y-m-d H:i:s'));
		
		return true;
	}

	/**
	 * get alternatif connected domain for ommu.oauth
	 * @param type $operator not yet using
	 * @return type
	 */
	public static function getOauthServerConnected() {
		//todo with operator
		$oauthServerOptions = Yii::app()->params['oauth_server_options'];
		$connectedUrl = 'neither-connected';
		
		foreach ($oauthServerOptions as $val)
		{
			if (self::getServerAvailible($val))
			{
				$connectedUrl = $val;
				break;
			}
		}
		file_put_contents('assets/oauth_server_is_active.txt', $connectedUrl);

		return $connectedUrl;
	}

	//returns true, if domain is availible, false if not
	public static function getServerAvailible($domain) 
	{
		//check, if a valid url is provided
		if (!filter_var($domain, FILTER_VALIDATE_URL))
			return false;

		//initialize curl
		$curlInit = curl_init($domain);
		curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
		curl_setopt($curlInit,CURLOPT_HEADER,true);
		curl_setopt($curlInit,CURLOPT_NOBODY,true);
		curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

		//get answer
		$response = curl_exec($curlInit);
		curl_close($curlInit);
		if($response)
			return true;

		return false;
	}

}