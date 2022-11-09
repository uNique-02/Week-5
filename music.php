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
            var $size_array = array();
            var $count=0;

            //retreives the file size of a file name
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


            //display the songs
            function displaysong($caller){
                $songs = glob('songs/*.mp3');
                foreach ($songs as $song){ 
                $size =  $this->file_size($song) ?>
                <?php
                    $this->song_array[$this->count]=basename($song);
                    $this->size_array[$this->count++]=$size;
                } ?>
                <?php
                switch($caller){ 
                    case 0: 
                        for($i=0; $i<$this->count; $i++){ ?>
                        <li class="mp3item">
                            <a href="songs/<?php echo $this->song_array[$i]; ?>"> <?php echo $this->song_array[$i]; echo $this->size_array[$i]; ?>
                        </li>
                        <?php }
                        break;
                    case 1:
                        $shuffled = $this->song_array;
                        shuffle($shuffled);
                        for($i=0; $i<$this->count; $i++){ ?>
                            <li class="mp3item">
                                <a href="songs/<?php echo $shuffled[$i]; ?>"> <?php echo $shuffled[$i]; echo $this->size_array[$i]; ?>
                            </li>
                            <?php }
                        break;
                }?>
            <?php
            } 

            //display the 
             function display_playlists(){
                    $playlists = glob('songs/*.txt');
                    foreach ($playlists as $file){ ?>
                        <li class="playlistitem">
                            <a href="music.php?playlist=<?php echo basename($file); ?>"> <?php echo pathinfo(basename($file))['filename'].".m3u" ;?></a>
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
        
        <!-- Back function-->
        <?php function backlink(){ ?>
                <a href="music.php">Back</a>
            <?php } ?>

        <?php $song = NULL?>
        
        <!-- Form -->
            <form method="$_REQUEST" >
                <ul id="musiclist" name="playlist">                   
                <?php
                //creates instance
                $song = new parent_class();
                $shuffle=NULL;
                $sort_bysize=NULL;
                
                //IF there is a request or when a song/playlist is clicked 
                if(!empty($_REQUEST["playlist"])){
                    $playlist = $_REQUEST["playlist"];
                    $path = pathinfo($playlist, PATHINFO_EXTENSION);
                }
                
                //If the request is a playlist
                if(!empty($playlist) && $path == "txt"){
                    $list = $playlist;
                    //stores the songs in the playlist
                    $content = file("songs/$list");
                    backlink();
                    //display the individual songs
                        foreach($content as $indiv_song){
                            $song->display_indivsong(trim($indiv_song));
                        } 
                }
                //IF shuffle is on, this function suffles the songs
                else if(!empty($_REQUEST["shuffle"])){
                    $shuffle = $_REQUEST["shuffle"];
                    if($shuffle=="on"){
                        $song->displaysong(1);
                        $song->display_playlists();
                    }
                    
                }
                //IF there is no shuffle orno playlistis clcked
                else if(empty($playlist) && empty($shuffle)){
                    $song->displaysong(0);
                    $song->display_playlists();
                } 
            
                ?>
                </ul>
            </form>    
		</div>
	</body>
</html>