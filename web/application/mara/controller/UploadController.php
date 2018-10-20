<?php
// +----------------------------------------------------------------------
// | Mara [ 1024马拉松 ]
// +----------------------------------------------------------------------
// | Group : 望江
// +----------------------------------------------------------------------
// | Author: 望江
// +----------------------------------------------------------------------

namespace app\mara\controller;

use app\common\assembly\Result;
use app\mara\dao\ReactionDao;
use app\mara\model\ReactionModel;
use mara\library\view\Controller;

class UploadController extends Controller
{
    public function image()
    {
        $targetDir = ROOT_PATH . '/public/uploads/';
        $targetFile = md5($targetDir . basename($_FILES['fileToUpload']['name']));

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST['submit'])) {
            $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
            if($check !== false) {
                echo 'File is an image - ' . $check['mime'] . '.';
                $uploadOk = 1;
            } else {
                echo 'File is not an image.';
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            Result::returnSuccessResult($targetFile, 'upload success');
        }

        // Check file size
        if ($_FILES['fileToUpload']['size'] > 5000000) {
            Result::returnFailedResult('Sorry, your file is too large.');
        }

        // Allow certain file formats
        if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif' ) {
            Result::returnFailedResult('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
        }

        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
            Result::returnSuccessResult($targetFile, '上传成功');
        } else {
            Result::returnFailedResult('Sorry, there was an error uploading your file.');
        }
    }
}
