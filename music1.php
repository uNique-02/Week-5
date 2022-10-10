<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Music Viewer</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="http://www.cs.washington.edu/education/courses/cse190m/09sp/labs/3-music/viewer.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div id="header">

		<h1>190M Music Playlist Viewer</h1>
		<h2>Search Through Your Playlists and Music</h2>
	</div>


	<div id="listarea">
		<ul id="musiclist">
			<?php
			$scan = glob('songs/*.mp3');
			foreach ($scan as $file) { ?>
				<?php if (!is_dir("$file")) { ?>
					<li class="mp3item">
						<a href="<?php echo $file; ?>"> <?php echo basename($file) ?></a>
					</li>
				<?php } ?>
			<?php } ?>

			<?php
			$playlist = null;
			$scan = glob('songs/*.txt');
			foreach ($scan as $file) { ?>
				<?php if (!is_dir("$file")) { ?>
					<li class="playlistitem" name="playlist">
						<a href="music.php?playlist=<?php echo basename($file); ?>" action="music.php"> <?php echo basename($file) ?></a>
					</li>
				<?php } ?>
			<?php } ?>

			<?php 
			
			$playlist = $_GET["playlist"]; 
			
			echo $playlist; 
			?>

			<?php
			$scans = file("$playlist");
			echo $scans[0];
			foreach ($scans as $file) { ?>
					<li class="mp3item">
						<a href="<?php echo $file; ?>"> <?php echo $file ?></a>
					</li>
			<?php } ?>
		</ul>
	</div>
</body>

</html>