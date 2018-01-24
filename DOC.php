<pre>
<?php
//print_r($_FILES);
function filesUploading($files){
    if (!isset($files['file'])) {
        return;
    }
    $file = $files['file'];

    /*if($file['size'] > 2000000){
        echo "Размер файла превышает три мегабайта";
        exit;
    }*/

    if ($file['error']){
        switch ($file['error']){
            case UPLOAD_ERR_FORM_SIZE:
                return 'Размер принятого файла превысил максимально допустимый размер.';
                break;
            case UPLOAD_ERR_PARTIAL:
                return 'Загружаемый файл был получен только частично.';
                break;
            case UPLOAD_ERR_NO_FILE:
                return 'Файл не был загружен.';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                return 'Не удалось записать файл на диск.';
                break;
        }
        return "Error file upload";
    }

    $file['name'] = strtolower($file['name']);
    $allowedTypesImg = [
        'jpg',
        'jpeg',
        'png'
    ];
    $allowedTypesDoc = [
            'pdf',
            'txt',
            'doc',
            'odt'
    ];
    $types = pathinfo($file['name'], PATHINFO_EXTENSION);
    if ((!in_array($types, $allowedTypesImg)) and (!in_array($types, $allowedTypesDoc))){
        return 'Wrong file type';
    }

    $allowedMimes = [
        'image/jpeg',
        'image/png',
        'image/jpg',
        'application/pdf',
        'text/plain',
        'application/msword',
        'application/vnd.oasis.opendocument.text'
        ];
    if (!in_array(($file['type']), $allowedMimes)){
        return 'Wrong mime type';
    }

    if (in_array($types,$allowedTypesDoc)){
    move_uploaded_file($file['tmp_name'], 'doc/' . $file['name']);
   }
    else {
        move_uploaded_file($file['tmp_name'], 'images/' . $file['name']);
    }
  return "File is uploaded";
}
echo filesUploading($_FILES);
?>
</pre>

<!DOCTYPE html>
<html>
<head>
    <title>!DOCTYPE</title>
    <meta charset="utf-8">
    <style>
    .form-path{
        width: 130px;
        margin: 10px 20px;
        color: #0000fa;
        font-size: medium;
    }
    p {
        color: darkblue;
        font-size: large;
         margin: 5px 10px;
     }
    </style>
</head>
<body>
<div class="form-path"><a href="DOC1.html">Download the file</a><br></div>
<p>Your downloaded files:</p>
<?php
$imgDir = 'images/';
function imagesDisplay($imgDir){
        $images ='';
        foreach (scandir($imgDir) as $item){
            if (in_array($item, ['.', '..'])){
                continue;
            }
            $images .= "<br><img style='width: 200px;' src='http://localhost/home_task_from_20.01.2018/images/". $item ."'><br>";
        }
    return $images;
}
echo imagesDisplay($imgDir);

echo "<br>";

$docDir = 'doc/';
function docsDisplay($docDir){
        $docsResult = '';
        foreach (scandir($docDir) as $docs){
            if (in_array($docs, ['.', '..'])){
                continue;
            }
            $docsResult .= "<li>".$docs."</li>";
        }
    return $docsResult;
}
echo docsDisplay($docDir);
?>

<!--Написать скрипт для загрузки пользовательских файлов. При загрузке, в зависимости от типа
файла – он на сервере должен помещаться в папку /doc, или /img..etc
Должно быть ограничение на прием файлов – не более 2 мб.
Ссылку на форму загрузки разместить на главной странице сайта.
После добавления файлов, при заходе на главную, пользователь должен видеть галерею ранее загруженных картинок,
и список загруженных документов (все, что не картинки).
Код максимально писать функциями.-->
</body>
</html>
