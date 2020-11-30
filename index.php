<?php
function CallAPI($method, $url)
{
    $curl = curl_init();
    // Optional Authentication:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
} ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel='manifest' href='egybest.webmanifest'>
    <meta name= “viewport” content=”width=device-width, user-scalable=no” />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>egy best API</title>
    <style>
    .card {
        margin: 1.5%;
    }
    </style>
</head>

<body>
    <form class="form-inline" action='/api/egybest/'>
        <div class="input-group mb-3">
            <input type="text" class="form-control" name='q' aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">search</button>
            </div>
        </div>
    </form>
    <div class="card-columns">
        <?php 

if(isset($_GET['q'])){
    $q = str_replace('+', '%20', $_GET['q']);
    $url = "http://localhost:8080/search?q=".$q;
    $url = str_replace(' ', '%20', $url);
    $response = CallAPI('GET',$url);

    $json = json_decode($response, true);
    foreach($json as $r){
        // image, tilte, type {static}
        $image = $r['image'];
        $title = $r['title'];
        $title = str_replace('-',' ', $title);
        $type = $r['type'];


        // for movies
        if($type == 'movie'){
            $long = $r['time'];
            $rate = $r['rate'];
            $url = $r['url'];
            echo '<div class="card">';
            echo '<img src="'.$image.'" class="card-img-top">';
            echo '<div class="card-body">';
            echo  '<h5 class="card-title">'.$title.'</h5>';
            echo  '<h5 class="card-subtitle mb-2 text-muted">'.$type.'</h5>';
            echo  '<a class="card-link" href="'.$url.'" target="_blank">watch</a>';

            echo '<ul class="list-group list-group-flush  text-muted">';
            echo  '<li class="list-group-item">rate: '.$rate.'/10</li>';
            echo  '<li class="list-group-item">time: '.$long.'</li>';
            echo '</ul>';
            
            echo '</div>';// for card body
            echo '</div>';// for card

        };

        // for series
        if ($type == 'series'){
            $season = $r['season'];
            echo '<div class="card">';
            echo '<img src="'.$image.'" class="card-img-top">';
            echo '<div class="card-body">';
            echo  '<h5 class="card-title">'.$title.'</h5>';
            echo  '<h5 class="card-subtitle mb-2 text-muted">'.$type.'</h5>';
            echo  '<div class="modal-footer">';
            echo  '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#episodes'.$season.'">episodes</button>';
            echo '<hr>';
            echo '<h5> season '.$season.'</h5>';
            echo '</div>';// for card footer
            echo '</div>';// for card body
            echo '</div>';// for card

            //model
            echo '<div class="modal fade" id="episodes'.$season.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="exampleModalLabel">season '.$season.'</h5>';
            echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';// for header
            echo '<div class="modal-body">';
            // table
            echo '<table class="table table-hover">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col">number</th>';
            echo '<th scope="col">rate</th>';
            echo '<th scope="col">time</th>';
            echo '<th scope="col">url</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach($r['episodes'] as $e){
                echo '<tr>';
                echo '<th scope="row">'.$e['number'].'</th>';
                echo '<td>'.$e['rate'].'</td>';
                echo '<td>'.$e['time'].'</td>';
                echo '<td><a href="'.$e['url'].'" targer="_blank">watch</a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';// for body
            echo '</div>';// for content
            echo '</div>';// for dialgo
            echo '</div>';// for modal
        }

    }
}

?>
    </div>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>

</body>

</html>