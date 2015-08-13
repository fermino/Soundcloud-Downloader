<?php
	require_once 'Core.php';

	class SoundCloud extends SoundCloudCore
	{
		public function DownloadTrack($URL)
		{
			$Track = $this->ResolveTrack($URL);

			if($Track !== false)
			{
				$TrackSources = $this->Get(array('tracks' => $Track['id'], 'streams'));

				if($TrackSources !== false)
				{
					if(isset($TrackSources['http_mp3_128_url']))
					{
						$Data = $this->Get($TrackSources['http_mp3_128_url'], array(), false, false, false);

						if(strlen($Data) > 0)
							return array('Author' => $Track['user']['username'], 'Title' => $Track['title'], 'Stream' => $Data);
					}
				}
			}

			return false;
		}

		private function ResolveTrack($URL)
		{
			$Track = $this->Get(array('resolve.json'), array('url' => $URL));

			if(isset($Track['kind']) && $Track['kind'] == 'track')
				return $Track;

			return false;
		}
	}