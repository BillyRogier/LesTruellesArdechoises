<?php

namespace App\Controller;

use App;
use App\Table\Contents;
use App\Table\Info;
use App\Table\Pages;
use App\Table\Pictures;
use App\Table\ProjectCategorys;
use App\Table\Projects;
use App\Table\Users;
use Core\Controller\AbstarctController;
use Core\Form\Type\EmailType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextareaType;
use Core\Form\Type\TextType;
use Core\Response\Response;
use Core\Route\Route;

class AppController extends AbstarctController
{
    private $app;

    public function __construct()
    {
        $this->app = App::getInstance();
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        $PagesTable = new Pages();
        $page = $PagesTable->findOneBy(['url' => ""]);

        $PicturesTable = new Pictures();
        $carousel_pictures = $PicturesTable->findAll("ORDER BY RAND() LIMIT 4");

        $ProjectCategorysTable = new ProjectCategorys();
        $ProjectCategorysTable
            ->innerJoin(Pictures::class)
            ->on("project_categorys.img_id = pictures.img_id");
        $project_categorys = $ProjectCategorysTable->findAll();

        $ContentsTable = new Contents();
        $ContentsTable
            ->innerJoin(Pictures::class)
            ->on("contents.img_id = pictures.img_id");
        $contents = $ContentsTable->findAllBy(['page_id' => $page->getId()]);

        return $this->render('/app/home.php', '/default.php', [
            'title' => 'Accueil',
            'carousels' => $carousel_pictures,
            'h1' => ucfirst($page->getTitle()),
            'contents' => $contents,
            'project_categorys' => $project_categorys,
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        $InfoTable = new Info();
        $info = $InfoTable->findOneBy(['id' => 1]);

        $form = $this->createForm("", "post", ['class' => 'form-contact grid'])
            ->add("name", TextType::class, ['autocomplete' => 'off', 'label' => 'name', 'id' => 'name'])
            ->add("email", EmailType::class, ['autocomplete' => 'off', 'label' => 'email', 'id' => 'email'])
            ->add("message", TextareaType::class, ['rows' => 10, 'cols' => 30, 'autocomplete' => 'off', 'label' => 'message', 'id' => 'message'])
            ->add("submit", SubmitType::class, ['value' => 'Envoyer', 'class' => 'btn'])
            ->getForm();

        if ($form->isSubmit()) {
            $error = $form->isXmlValid();
            if ($error->noError()) {
                $data = $form->getData();

                $name = $data['name'];
                $email = $data['email'];
                $message = $data['message'];
                $to = "" . $info->getEmail() . "";
                $subject = 'Message reçu via le site web';
                $headers = "Content-type: text/html; charset=iso-8859-1\r\n";
                $send_email = mail($to, $subject, $message, $headers, "-f" . $email . "");

                if (!$send_email) {
                    $_SESSION["message"] = $error->danger("Une erreur est survenue", 'error_container');
                } else {
                    $_SESSION["message"] = $error->success("Email envoyé avec succès");
                }

                $error->location(URL . "/contact", "success_location");
                $error->getXmlMessage("");
            }
            $error->getXmlMessage("");
        }

        return $this->render('/app/contact.php', '/default.php',  [
            'title' => 'Contact',
            'form' => $form->createView(),
            'info' => $info,
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        if ($this->isAdmin()) {
            $this->headLocation("/admin");
        }
        $UsersTable = new Users();

        $formBuilder = $this
            ->createForm("", "post", ['class' => 'grid'])
            ->add("email", EmailType::class, ['label' => 'email', 'id' => 'email'])
            ->add("password", PasswordType::class, ['label' => 'mot de passe', 'id' => 'password'])
            ->add("submit", SubmitType::class, ['value' => 'login', 'class' => 'btn'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();
                $user = $UsersTable->findOneBy(['email' => $data['email']]);

                if ($user) {
                    if (password_verify($data["password"], $user->getPassword())) {
                        $_SESSION['admin'] = $user->getId();
                        $_SESSION["message"] = $error->success("successfully login");
                        $error->location(URL . "/admin", "success_location");
                    } else {
                        $error->danger("Email or password incorrect", 'error_container');
                    }
                } else {
                    $error->danger("Email or password incorrect", 'error_container');
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/app/login.php', '/login.php', [
            'title' => 'Login',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/project/{name}', name: 'project_categorys')]
    public function projectCategorys(string $name): Response
    {
        $ProjectCategorysTable = new ProjectCategorys();
        $project_category = $ProjectCategorysTable->findOneBy(['url' =>  $name]);

        if (!isset($name) || empty($name) || !$project_category) {
            $this->headLocation("/");
        }

        $ProjectsTable = new Projects();
        $ProjectsTable
            ->innerJoin(Pictures::class)
            ->on("projects.img_id = pictures.img_id")
            ->innerJoin(Pages::class)
            ->on("projects.page_id = pages.id");

        $projects = $ProjectsTable->findAllBy(['projects.category_id' =>  $project_category->getId()]);

        return $this->render('/app/project_categorys.php',  '/default.php', [
            'title' => 'Project | ' . $project_category->getName(),
            'h1' => ucfirst($project_category->getName()),
            'project_category' => $project_category,
            'projects' => $projects,
        ]);
    }

    #[Route('/project/{category}/{name}', name: 'projects')]
    public function projects(string $category, string $name): Response
    {
        $PagesTable = new Pages();
        $page = $PagesTable->findOneBy(['url' => $name]);

        if (!isset($name) || empty($name) || !$page) {
            $this->headLocation("/$category");
        }

        $ContentsTable = new Contents();
        $ContentsTable
            ->innerJoin(Pictures::class)
            ->on("contents.img_id = pictures.img_id");
        $contents = $ContentsTable->findAllBy(['page_id' => $page->getId()]);

        return $this->render('/app/project.php', '/default.php',  [
            'title' => 'Project |' . $category . ' | ' . $name,
            'h1' => ucfirst($page->getTitle()),
            'contents' => $contents,
        ]);
    }
}
