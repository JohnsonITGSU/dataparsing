<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>File Upload</title>
</head>
<body>



<?php
  require_once "../dependancies/vendor/autoload.php";

use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Common\Internal\Resources;
use MicrosoftAzure\Storage\Common\Internal\StorageServiceSettings;
use MicrosoftAzure\Storage\Common\Models\Range;
use MicrosoftAzure\Storage\Common\Models\Metrics;
use MicrosoftAzure\Storage\Common\Models\RetentionPolicy;
use MicrosoftAzure\Storage\Common\Models\ServiceProperties;
use MicrosoftAzure\Storage\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\SharedAccessSignatureHelper;
use MicrosoftAzure\Storage\File\Models\CreateShareOptions;
use MicrosoftAzure\Storage\File\Models\ListSharesOptions;
use MicrosoftAzure\Storage\File\FileRestProxy;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=cs2df4001706467x45c1xaf3;AccountKey=cuK0TrZW0Oy+gZcWFz9t1/oeQPyH3XViQizBtnZUXOTz1aIfY/JVghWN1+D4drO0J1mCAT6FYORa/ObTcmstVw==;EndpointSuffix=core.windows.net";
$fileClient = ServicesBuilder::getInstance()->createFileService($connectionString);

function uploadFile($fileClient) {

    // Get the content of the uploaded file
    $content = file_get_contents($_FILES["logfiles"]["tmp_name"]);
    // Get uploaded file name
    $filename = $_FILES["logfiles"]["name"];

    // Change the share name to mydisk (all lowercase)
    $shareName = 'mydisk';
    try {
        // Use createFileFromContent instead of createFileFromContentAsync
        $fileClient->createFileFromContent($shareName, $filename, $content, null);
        echo "<p style='color:green;'>File Uploaded successfully </p>";

    } catch (ServiceException $e) {
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code . ": " . $error_message . PHP_EOL;
    }
}

?>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    Upload a file:
    <input type="file" name="logfiles" id="logfiles">
    <input type="submit" value="Upload" name="submit">
</form>
</body>
</html>
