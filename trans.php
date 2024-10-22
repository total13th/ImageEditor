<?php

if(isset($_FILES['image'])){
    $file = $_FILES['image']['tmp_name'];

    $ch = curl_init();

    $url = "http://localhost:5000/blur";

    $preFile = new CURLFile($file, $_FILES['image']['type'], $_FILES['image']['name']);

    $data = array('image' => $preFile);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if($response === false){
        echo "Error: ". curl_error($ch);
    }else{

        // Create a unique filename to store the processed image
        $processed_image_path = 'Blured Image' . time() . '.jpg';

        // Save the processed image to the server
        file_put_contents($processed_image_path, $response);

        $imgData = base64_encode($response);
        echo '<img src="data:image/jpeg;base64,'. $imgData . '" alt="Processed Image">';

        echo '<a href="' . $processed_image_path . '" download="Blured Image.jpg">Download</a>';
    }
    curl_close($ch);

}else{
    echo "Error While uploading";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="func.js"></script>
</head>
<body>
    <button onclick="goBack()">Back</button>
    <!---->
</body>
</html>

