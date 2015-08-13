<?php
	##### CONFIG #####
		$ClientID = '';
	##### CONFIG #####

	require_once 'class/Soundcloud.php';

	if(!empty($ClientID) && !empty($_GET['url']))
	{
		$Soundcloud = new Soundcloud($ClientID);

		$Track = $Soundcloud->DownloadTrack($_GET['url']);

		if($Track !== false)
		{
			header('Content-type: audio/mpeg');
			header('Content-length: ' . strlen($Track['Stream']));

			echo $Track['Stream'];

			exit;
		}
	}

	exit('Error');