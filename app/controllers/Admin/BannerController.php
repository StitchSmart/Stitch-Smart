<?php

require_once BASE_PATH.'/app/models/settings.php';

class BannerController {

    public function add()
    {
        if(isset($_POST['addbanner'])){
            $errors = [];
            $alt = trim($_POST['alt'] ?? '');
            $text = trim($_POST['text'] ?? '');

            if (empty($text)) {
                $errors['text'] = "Fill the Banner Name field.";
            }
            if (empty($alt)) {
                $errors['alt'] = "Fill the Banner Text field.";
            }
            if (empty($_FILES['bimage']['name'])) {
                $errors['bimage'] = "Banner Image is required.";
            }

            if (!empty($_FILES['bimage']['name'])) {
                $allowed = ['image/jpeg', 'image/png', 'image/webp'];
                if (!in_array($_FILES['bimage']['type'], $allowed)) {
                    $errors['bimage'] = "Invalid image type. JPG, PNG, WEBP allowed.";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = [
                    'text' => $text,
                    'alt' => $alt
                ];
                header("Location: " . BASE_URL . "index.php?page=banner_add");
                exit;
            }

            $bannerModel = new Banner();
            $result = $bannerModel->addbanner($alt, $text, $_FILES['bimage']);

            if($result === true){
                $_SESSION['success'] = "Banner added successfully!";
                header("Location: " . BASE_URL . "index.php?page=homepage");
                exit;
            } else {
                $_SESSION['errors'] = [$result];
                header("Location: " . BASE_URL . "index.php?page=banner_add");
                exit;
            }
        }
        $data = [
    'title' => 'Banners',
    'theme' => $_SESSION['theme'] ?? 'theme-luxury',
    'view' => 'admin/banner.php',
    
];

extract($data);
        require_once BASE_PATH . '/app/views/admin/layout.php';
    }

    public function edit()
{
    $bannerModel = new Banner();

    $id = $_GET['id'];

    if(isset($_POST['updatebanner'])){
        $errors = [];
        $alt = trim($_POST['alt'] ?? '');
        $text = trim($_POST['text'] ?? '');

        if (empty($alt)) $errors[] = "Banner Alt Text is required.";

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: " . BASE_URL . "index.php?page=edit_banner&id=" . $id);
            exit;
        }

        $bannerModel->updateBanner($id,$alt,$text,$_FILES['bimage']);
        $_SESSION['success'] = "Banner updated successfully!";
        header("Location: ".BASE_URL."index.php?page=homepage");
        exit;
    }

    $banner = $bannerModel->getBannerById($id);
       $data = [
    'title' => 'Edit Banners',
    'theme' => $_SESSION['theme'] ?? 'theme-luxury',
    'view' => 'admin/banner_edit.php',
    'banner' => $banner,
];

extract($data);
        require_once BASE_PATH . '/app/views/admin/layout.php';
    }

    
public function delete()
{
    $bannerModel = new Banner();

    $id = $_GET['id'];

    $bannerModel->deleteBanner($id);

    header("Location: ".BASE_URL."index.php?page=homepage");
}

}
