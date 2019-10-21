
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Samehadaku Bypass</title>
    <link rel="shortcut icon" href="http://www.khalid48.co/assets/images/favicon.png"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        body{
            background-color: #F2F1EF;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <center>
            <h2>SAMEHADAKU BYPASS</h2>
        </center>
        <form method="post" class="form-horizontal">
            <div class="form-group">
                <label>URL</label>
                <input type="text" placeholder="https://www.samehadaku.tv/black-clover-episode-94/" class="form-control" name="link" required>
            </div>  
            <div class="form-group">
                <input type="submit" name="send" value="Bypass" class="btn btn-primary btn-block">
            </div>  
        </form>
        <?php 
        if(!empty($_POST) || isset($_GET['link'])){
            include "samehadakuClass.php";
            $sm = new samehadakuClass();

            if(isset($_POST['link'])){
                $link = $_POST['link'];
            }else if(isset($_GET['link'])){
                $link = base64_decode($_GET['link']);
            }else{
                $link = '';
            }

            $myfile = fopen("url_history.txt", "a") or die("Unable to open file!");
            $txt = $link."\r\n";
            fwrite($myfile, $txt);
            fclose($myfile);
            $plink = parse_url($link);
            if(isset($plink['host'])&&$plink['host']=='www.samehadaku.tv'&&!empty($link)){
                $slug = explode('/', $link);
                $slug = $slug[3];
                $selected_anime_slug = $slug;
                $anime_detail = $sm->getAnimeDetails($selected_anime_slug);
                ?>
                <div class="card">
                  <div class="card-header">
                    Hasil
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title"><?=$anime_detail['title']?></h5>
                            <p class="card-text">
                                <?php 
                                if(!empty($anime_detail['genre'])){
                                    ?>
                                    <b>Genre</b>
                                    <p><?=$anime_detail['genre']?></p>
                                <?php } ?>
                                <?php 
                                if(!empty($anime_detail['synopsis'])){
                                    ?>
                                    <b>Sinopsis</b>
                                    <p><?=$anime_detail['synopsis']?></p>
                                <?php } ?>
                            </p>
                            <hr>

                            <?php 
                            foreach($anime_detail['download_links'] as $key => $value){
                                ?>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div style="font-weight: bold;" class="card-title">
                                            <?=$anime_detail['video_type'][$key]?>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <?php               
                                            foreach($value as $k => $v){
                                                echo '<li class="list-group-item"> ';
                                                ?>
                                                <span class="quality-video"><?=$k?></span>
                                                <?php
                                                foreach($v as $l){
                                                    ?>
                                                    <a class='btn btn-primary' target="blank" href='redirect.php?u=<?=base64_encode($l['link'])?>'><?=$l['server']?></a>
                                                    <?php
                                                }
                                                echo "</li>";
                                            }
                                            ?>
                                        </ul> 
                                    </div>
                                </div>
                                <?php
                // echo "<b>".."</b><br>";
                // foreach($value as $k => $v){
                //  echo $k." | ";
                //  foreach($v as $l){
                //      echo "<a style='margin-right:20px;' href='samehadaku_link.php?u=".$l->link."'>".$l->server."</a>";
                //  }
                //  echo "<br>";
                // }
                            }                                   
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php 
                            $list = $sm->getAnimesByTag($anime_detail['tag']);
                            ?>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Episode Lainnya</h5>
                                    <ul>
                                        <?php 
                                        foreach($list as $l){
                                            if($l['href']!==$link){
                                                echo '<li><a href="?link='.base64_encode($l['href']).'">'.$l['title'].'</a></li>';

                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }else{
                echo '<div class="alert alert-danger" role="alert">Link yang anda masukkan tidak valid</div>';
            }
        }
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>