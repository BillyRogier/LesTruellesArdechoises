<?php

namespace App\Controller;

use App;
use App\Table\Carousel;
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

        $CarouselTable = new Carousel();
        $CarouselTable
            ->innerJoin(Pictures::class)
            ->on("carousel.img_id = pictures.img_id");
        $carousel_pictures = $CarouselTable->find("MIN(pictures.alt) AS alt, pictures.src", "GROUP BY src ORDER BY RAND() LIMIT 5");

        $ProjectCategorysTable = new ProjectCategorys();
        $ProjectCategorysTable
            ->innerJoin(Pictures::class)
            ->on("project_categorys.img_id = pictures.img_id");
        $project_categorys = $ProjectCategorysTable->findAll();

        $ContentsTable = new Contents();
        $ContentsTable
            ->innerJoin(Pictures::class)
            ->on("contents.img_id = pictures.img_id");
        $content = $ContentsTable->findOneBy(['page_id' => $page->getPage_id()]);

        return $this->render('/app/home.php', '/default.php', [
            'title' => 'Accueil',
            'desc' => "Les Truelles Ardéchoises, entreprise de maçonnerie de renom dirigée par Arthur Rogier, offre des services de construction, de rénovation et de restauration de qualité supérieure pour des structures en pierre et en béton. Avec une équipe de maçons qualifiés, des matériaux durables et un engagement envers la satisfaction du client, Les Truelles Ardéchoises est l'entreprise de choix pour tout projet de maçonnerie dans le département de l'Ardèche, en France.",
            'carousels' => $carousel_pictures,
            'h1' => ucfirst($page->getTitle()),
            'content' => $content,
            'project_categorys' => $project_categorys,
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        $PagesTable = new Pages();
        $page = $PagesTable->findOneBy(['url' => ""]);

        $ContentsTable = new Contents();
        $ContentsTable
            ->innerJoin(Pictures::class)
            ->on("contents.img_id = pictures.img_id");
        $contents = $ContentsTable->findAllBy(['page_id' => $page->getPage_id()]);

        return $this->render('/app/about.php', '/default.php', [
            'title' => 'À propos',
            'desc' => "",
            'h1' => "À propos",
            'contents' => $contents,
        ]);
    }

    #[Route('/project', name: 'projects catégorie')]
    public function project(): Response
    {
        $ProjectCategorysTable = new ProjectCategorys();
        $ProjectCategorysTable
            ->innerJoin(Pictures::class)
            ->on("project_categorys.img_id = pictures.img_id");
        $project_categorys = $ProjectCategorysTable->findAll();

        return $this->render('/app/projects.php', '/default.php', [
            'title' => 'Projets',
            'desc' => "",
            'project_categorys' => $project_categorys,
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        $InfoTable = new Info();
        $info = $InfoTable->findOne();

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
                $to = $info->getEmail();
                $subject = 'Message reçu via le site web';
                $message = $data['message'];
                $headers = 'From: ' . $email . ''       . "\r\n" .
                    'Nom: ' . $name . ''       . "\r\n" .
                    'Reply-To: ' . $email . '' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                $send_email = mail($to, $subject, $message, $headers);

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
            'desc' => "",
            'form' => $form->createView(),
            'info' => $info,
        ]);
    }

    #[Route('/mentions-legales', name: 'mentions légales')]
    public function mentionsLegales(): Response
    {
        $InfoTable = new Info();
        $info = $InfoTable->findOne();

        return $this->render('/app/mentions_legales.php', '/default.php',  [
            'title' => 'Contact',
            'desc' => "",
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
            ->on("projects.page_id = pages.page_id");

        $projects = $ProjectsTable->findAllBy(['projects.category_id' =>  $project_category->getId()]);

        return $this->render('/app/project_categorys.php',  '/default.php', [
            'title' => 'Project | ' . $project_category->getName(),
            'desc' => "",
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
        $contents = $ContentsTable->findAllBy(['contents.page_id' => $page->getPage_id()]);

        return $this->render('/app/project.php', '/default.php',  [
            'title' => 'Project |' . $category . ' | ' . $name,
            'desc' => "",
            'h1' => ucfirst($page->getTitle()),
            'contents' => $contents,
        ]);
    }
}
