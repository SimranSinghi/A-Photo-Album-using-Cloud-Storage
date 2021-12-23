<?php
// put your generated access token here (should have No Expiration)
$auth_token = 'XyFDvqLIxrIAAAAAAAAAAfh4PQr8Su2smGpGPXspCaKSpbs5rloTswt3N6SKp64M';

// set it to true to display debugging info
$debug = true;



function download ( $path, $target_path ) {
   
   global $auth_token, $debug;
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $auth_token,
                'Content-Type:', 'Dropbox-API-Arg: {"path":"/'.$path.'"}'));
   curl_setopt($ch, CURLOPT_URL, 'https://content.dropboxapi.com/2/files/download');
   try {
     $result = curl_exec($ch);
     echo '<br>';
     echo("$path Image is Downloaded Successfully!");
     echo '<br>';
     
   } catch (Exception $e) {
     echo 'Error: ', $e->getMessage(), "\n";
   }
   file_put_contents($target_path,$result);
   curl_close($ch);
}

function delete ( $path) {
   
   $d = '/'.$path;
   global $auth_token, $debug;
   $args = array("path" => $d);
   
   $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/2/files/delete_v2');
    $headers = array(
       "Authorization: Bearer " . $auth_token,
       "Content-Type: application/json",
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
    

   try {
     $result = curl_exec($ch);
     echo '<br>';
     echo("$path Image is Delete Successfully!");
     echo '<br>';
     header(("Location: sample.php"));
   } catch (Exception $e) {
     echo 'Error: ', $e->getMessage(), "\n";
   }
   if ($debug)
      print_r($result);
      curl_close($ch);
   

}


function upload ( $path ) {
   
   global $auth_token, $debug;
   $args = array("path" => $path, "mode" => "add");
   $fp = fopen($path, 'rb');
   $size = filesize($path);
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_PUT, true);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $auth_token,
             'Content-Type: application/octet-stream',
             'Dropbox-API-Arg: {"path":"/'.$path.'", "mode":"add"}'));
   curl_setopt($ch, CURLOPT_URL, 'https://content.dropboxapi.com/2/files/upload');
   curl_setopt($ch, CURLOPT_INFILE, $fp);
   curl_setopt($ch, CURLOPT_INFILESIZE, $size);
   try {
     $result = curl_exec($ch);
   } catch (Exception $e) {
     echo 'Error: ', $e->getMessage(), "\n";
   }
   if ($debug)
      print_r($result);
      curl_close($ch);
   fclose($fp);
}

function directoryList ( $path ) {
   global $auth_token, $debug;
   $args = array("path" => $path);
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $auth_token,
            'Content-Type: application/json'));
   curl_setopt($ch, CURLOPT_URL, 'https://api.dropboxapi.com/2/files/list_folder');
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
   try {
     $result = curl_exec($ch);
   } catch (Exception $e) {
     echo 'Error: ', $e->getMessage(), "\n";
   }
   if ($debug)
      // print_r($result);
   $array = json_decode(trim($result), TRUE);
   if ($debug)
      // print_r($array);
   curl_close($ch);
   return $array;
}



if (isset($_POST['submit'])){
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    echo $fileName, "\n";
    $fileTmpName = $_FILES['file']['tmp_name'];
    echo $fileTmpName, "\n";
    $fileSize = $_FILES['file']['size'];
    echo $fileSize, "\n";
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
   
    upload($fileName);
   
}

?>


<script type="text/javascript">

  function myFunction(fileName){
     download($fileName,"images/".$fileName);
  }

</script>
<!DOCTYPE html>
<html>
<head>
<h1 style="color:black;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-align: center; ">SIMRAN SINGHI:PROJECT6:WDM</h1>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
    <title></title>
</head>
<body>

<?php $result = directoryList(""); ?>

<table>
    <?php foreach($result['entries'] as $key=>$value): ?>
    <tr>
        <td><?= $value['name']; ?></td>
        <td><a href="sample.php?img_download=<?php echo $value['name'] ?>">Download</a></td>
        <td><a href="sample.php?img_delete=<?php echo $value['name'] ?>">Delete</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
if (isset($_GET['img_download'])) {
    $n = $_GET['img_download'];

    download($n,"images/".$n);

}

if (isset($_GET['img_delete'])) {
    $n = $_GET['img_delete'];

    delete($n);
}
?>


<form style="background-color:cornflowerblue; border: 5px; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;border-radius: 10px;" action="sample.php" method="POST" enctype="multipart/form-data">
     <input type="file" name="file">
     <button type="submit" name="submit">UPLOAD A FILE</button>
</form> 
<div>
  <h2 style="color:black;"  name="IS">--IMAGE SECTION--</h2>
  <img style="height: 300px; width: 300px" id="displayImg" src="images\<?php echo $n ?>">
  
</div>   
<style>
      <!-- /* Always set the map height explicitly to define the size of the div -->
       <!-- * element that contains the map. */ -->
      
      body{
        background-image: url('image2.jpg');
      }
      a:link {
  color: red;
}

a:visited {
  color: green;
}

a:hover {
  color: hotpink;
}

a:active {
  color:blue;
}
  </style>
</body>
</html>