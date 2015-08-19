<?php
	require_once '../config.php';
	require_once '../class/Soundcloud.php';

	if(!empty($ClientID))
	{
		if(!empty($_GET['url']))
		{
			$Soundcloud = new Soundcloud($ClientID);

			$Track = $Soundcloud->DownloadTrack($_GET['url']);

			if($Track !== false)
			{
				echo json_encode(array('status' => 'ok', 'author' => $Track['Author'], 'title' => $Track['Title']));
				echo "\n";
				echo $Track['Stream'];
			}
			else
				echo json_encode(array('status' => 'error', 'code' => 0, 'message' => "Can't download track"));
		}
		else
			echo json_encode(array('status' => 'error', 'code' => -10, 'message' => 'Missing GET[url]'));
	}
	else
		echo json_encode(array('status' => 'error', 'code' => -20, 'message' => 'Missing local ClientID'));