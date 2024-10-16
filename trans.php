<?php

if(isset($_FILES['image'])){
    $file = $_FILES['image']['tmp_name'];

    $ch = curl_init();

    $url = "http://loaclhost:5000/blur";

    $preFile = new CURLFile($file, $_FILES['image']['type'], $_FILES['image']['name']);

    $data = array('image' => $preFile);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLPOT_POST, 1);
    curl_setopt($ch, CURLPOT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if($response === false){
        echo "Error: ". curl_error($ch);
    }else{
        $imgData = base64_encode($response);
        echo '<img src="data:image/jpeg;base64,'. $imgData . '" alt="Processed Image">';
    }
    curl_close($ch);
}

?>