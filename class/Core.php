<?php
	require_once 'Unirest.php';

	class SoundCloudCore
	{
		const ENDPOINT = 'https://api.soundcloud.com';

		protected $SuccessCodes = array(200, 301, 302);

		private $ClientID = null;

		public function __construct($ClientID)
		{
			$this->ClientID = $ClientID;
		}

		protected function Get($Request, Array $Parameters = array(), $ParseJson = true, $WithClientID = true, $WithEndpoint = true)
		{
			$URL = '';

			if(is_array($Request))
			{
				foreach($Request as $Key => $Value)
				{
					if(is_int($Key))
						$URL .= "/{$Value}";
					else
						$URL .= "/{$Key}/{$Value}";
				}
			}
			else
				$URL .= '/' . $Request;

			if($WithEndpoint)
				$URL = self::ENDPOINT . $URL;
			else
				$URL = substr($URL, 1);

			try
			{
				$Parameters = $WithClientID ? array_merge(array('client_id' => $this->ClientID), $Parameters) : $Parameters;

				$Response = Unirest\Request::get($URL, array(), $Parameters);

				if(in_array($Response->code, $this->SuccessCodes))
				{
					if($ParseJson)
					{
						$Response = json_decode($Response->raw_body, true);

						if(is_array($Response))
							return $Response;
					}
					else
						return $Response->raw_body;
				}
			}
			catch(Exception $Exception)
			{
				error_log(sprintf("[%s] Exception: %s", date('Y-m-d h:i:s'), $Exception->getMessage()));
			}

			return false;
		}
	}