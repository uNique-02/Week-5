<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Music Viewer</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="http://www.cs.washington.edu/education/courses/cse190m/09sp/labs/3-music/viewer.css" type="text/css" rel="stylesheet" />
	</head>

    <?php
		class parent_class{
            var $song_array = array();
            var $count=0;

            function printarray(){
                echo "KIM CUTE";
                for($i=0; $i<3; $i++){ ?>
                    <li class="mp3item">
                    <?php echo $this->song_array[$i]; ?>
                    </li>
                <?php }
            }

            function file_size($filename){
                    $size=filesize($filename);
                if( $size>1023 && $size<1048575){
                    $size = $size/1024;
                    $size = " (". $size." kb)";
                }
                else if(file_exists($filename) && $size>1048575){
                    $size = $size/1048576;
                    $size = " (". round($size, 2) ." mb)";
                }
                else{
                    $size = " (". $size." b)";
                }

                return $size;
                }

            function displaysong(){
                 $songs = glob('songs/*.mp3');
                foreach ($songs as $song){ 
                $size =  $this->file_size($song) ?>
                    <li class="mp3item">
					    <a href="<?php echo $song; ?>"> <?php echo basename($song); echo $size;
                        $this->song_array[$this->count++]=basename($song);
                        ?></a>
				    </li>
                <?php } 
            } 

             function display_playlists(){
                    $playlists = glob('songs/*.txt');
                    foreach ($playlists as $file){ ?>
                        <li class="playlistitem">
                            <a href="music.php?playlist=<?php echo basename($file); ?>"> <?php echo pathinfo(basename($file))['filename'].".m3u" ; echo $this->file_size($file);?></a>
                        </li>
                 <?php } 
             }

             function display_indivsong($file){ ?>
                <li class="mp3item">
                    <?php $path = "songs/$file";?>
                    <a href="<?php echo $path?>"> <?php echo $file; echo $this->file_size($path);?></a>
                </li>

            
             <?php }
            
    } ?>

	<body>
        
		<div id="header">

			<h1>190M Music Playlist Viewer</h1>
			<h2>Search Through Your Playlists and Music</h2>
            
		</div>
		
		<div id="listarea">
        
        <?php function backlink(){ ?>
                <a href="music.php">Back</a>
            <?php } ?>

        <?php $song = NULL?>
            <form method="$_REQUEST" >
                <ul id="musiclist" name="playlist">                   
                <?php
                $song = new parent_class();
                $shuffle=NULL;
                $sort_bysize=NULL;

                if(!empty($_REQUEST["playlist"])){
                    $playlist = $_REQUEST["playlist"];
                    $path = pathinfo($playlist, PATHINFO_EXTENSION);
                }
                
                if(empty($playlist)){
                    $song->displaysong();
                    $song->display_playlists();
                } 
                else if(!empty($playlist) && $path == "txt"){
                    $list = $playlist;
                    $content = file("songs/$list");
                    backlink();
                        foreach($content as $indiv_song){
                            $song->display_indivsong(trim($indiv_song));
                        } 
                }
                if(!empty($_REQUEST["shuffle"])){
                    $shuffle = $_REQUEST["shuffle"];
                }
                if(!empty($_REQUEST["bysize"])){
                    $sort_bysize = $_REQUEST["bysize"];
                }
                
                if($shuffle=="on"){
                    echo $song->printarray();
                } 
                else{

                }
                if($sort_bysize=="on"){

                }else{

                }
                ?>
                </ul>
            </form>    
		</div>
	</body>
</html>