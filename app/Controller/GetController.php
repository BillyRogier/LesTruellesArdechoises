<?php

namespace App\Controller;

use App;
use App\Table\Contents;
use App\Table\Pictures;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\FileType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextareaType;
use Core\Form\Type\TextType;
use Core\Response\Response;
use Core\Route\Route;


class GetController extends AbstarctController
{
    private  $app;

    public function __construct()
    {
        if (!$this->isAdmin()) {
            $this->headLocation("/login");
        }
        $this->app = App::getInstance();
    }

    #[Route('/get/delete-content', name: 'form_content')]
    public function getDeleteContent()
    {
        $ContentTable = new Contents();
        $ContentTable
            ->innerJoin(Pictures::class)
            ->on("contents.img_id = pictures.img_id");
        $content = $ContentTable->findOneBy(['id' =>  $_POST['id']]);

        if ($content) {
            $old_img = $content->getJoin(Pictures::class)->getSrc();
            $imgs = $ContentTable->getJoin(Pictures::class)->findAllBy(['img_id' => $content->getImg_id()]);
            $uploads_dir = ROOT . '\public\assets\img';
            $ContentTable->delete(['id' => $_POST['id']]);

            if (count($imgs) <= 1) {
                if (file_exists("$uploads_dir\\$old_img")) {
                    unlink("$uploads_dir\\$old_img");
                }

                $ContentTable->getJoin(Pictures::class)->delete(['img_id' => $content->getImg_id()]);
            }
        }
    }

    #[Route('/get/form-content', name: 'form_content')]
    public function getFormContent()
    {
        $formContent = $this->createForm("", "post", ['class' => 'grid'])
            ->add("id", HiddenType::class)
            ->add("subtitle", TextType::class, ['label' => 'Subtitle', 'id' => uniqid()])
            ->add("img", HiddenType::class)
            ->add("file", FileType::class, ['class' => 'file', 'label' => 'file', 'id' => uniqid()])
            ->add("text", TextareaType::class, ['label' => 'Descripition', 'id' => uniqid()])
            ->add("submit", SubmitType::class, ['class' => 'btn', 'value' => 'save'])
            ->getForm();

        echo  $formContent->createView();
    }

    #[Route('/get/image', name: 'image_html')]
    public function getImage()
    {
        echo URL . "/assets/img/";
    }

    #[Route('/get/upload-image', name: 'upload_image')]
    public function uploadImage()
    {
        // $uploads_dir = ROOT . '\public\assets\img';  
        // if (isset($_FILES["file"])) {
        $tmp_name = $_FILES["file"]["tmp_name"];
        // $name = basename($_FILES["file"]["name"]);
        // if (!file_exists("$uploads_dir\\$name")) {
        //     move_uploaded_file($tmp_name, "$uploads_dir\\$name");
        // }
        // }
        echo $tmp_name;
    }

    #[Route('/get/delete-image', name: 'delete_image')]
    public function deleteImage()
    {
        if (isset($_POST["src"])) {
            $carouselTable = $this->app->getTable('Carousels');
            $projectsTable = $this->app->getTable('Projects');
            $contentTable = $this->app->getTable('Content');
            $projectCategoriesTable = $this->app->getTable('ProjectCategories');
            if (
                !$carouselTable->findAllBy(['img' => $_POST["src"]]) &&
                !$projectsTable->findAllBy(['product_img' => $_POST["src"]]) &&
                !$contentTable->findAllBy(['img' => $_POST["src"]]) &&
                !$projectCategoriesTable->findAllBy(['img' => $_POST["src"]])
            ) {
                unlink(ROOT . "/public/assets/img/" . $_POST["src"]);
            }
        }
    }

    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        $usersTable = $this->app->getTable('Users');

        $formBuilder = $this
            ->createForm()
            ->add("email", EmailType::class)
            ->add("password", PasswordType::class)
            ->add("submit", SubmitType::class, ['value' => 'register'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($usersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();
                $user = $usersTable->findOneBy(['email' => $data['email']]);

                if ($user) {
                    $error->danger("Email already associated to an account", 'error_container');
                } else {
                    $usersTable
                        ->setEmail($data["email"])
                        ->setPassword(password_hash($data["password"], PASSWORD_DEFAULT))
                        ->flush();

                    $userid = $usersTable->lastInsertId();
                    $_SESSION['user'] = $userid;
                }

                if ($error->noError()) {
                    $_SESSION["message"] = $error->success("account create successfully");
                    $error->location(URL . "/", "success_location");
                    $error->getXmlMessage($this->app->getProperties(Users::class));
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/login.php', '/login.php', [
            'title' => 'Register',
            'form' => $formBuilder->createView(),
        ]);
    }
}
