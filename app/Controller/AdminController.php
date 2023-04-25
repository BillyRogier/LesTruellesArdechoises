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
use Core\Form\Type\ChoiceType;
use Core\Form\Type\EmailType;
use Core\Form\Type\FileType;
use Core\Form\Type\HiddenType;
use Core\Form\Type\NumberType;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextareaType;
use Core\Form\Type\TextType;
use Core\Response\Response;
use Core\Route\Route;

class AdminController extends AbstarctController
{
    private  $app;

    public function __construct()
    {
        if (!$this->isAdmin()) {
            $this->headLocation("/login");
        }
        $this->app = App::getInstance();
    }

    #[Route('/admin', name: 'admin')]
    public function admin()
    {
        return $this->render('/admin/index.php', '/admin.php', [
            'title' => 'Admin | Accueil',
        ]);
    }

    /**
     * Update home title
     */
    #[Route('/admin/home', name: 'home')]
    public function home()
    {
        $PagesTable = new Pages();
        $page = $PagesTable->findOneBy(['url' => ""]);

        $form = $this->createForm("", "post", ['class' => 'grid'])
            ->add("id", HiddenType::class, ['value' => $page->getPage_id()])
            ->add("title", TextareaType::class, ['value' => $page->getTitle(), 'label' => 'Title', 'id' => "title"])
            ->add("submit", SubmitType::class, ['value' => 'Save', 'class' => 'btn'])
            ->getForm();

        if ($form->isSubmit()) {
            $error = $form->isXmlValid($PagesTable);
            if ($error->noError()) {
                $data = $form->getData();

                $page
                    ->setTitle($data["title"])
                    ->flush();

                $_SESSION["message"] = $error->success("success");
                $error->location(URL . "/admin/home", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Pages::class));
        }

        return $this->render('/admin/home.php', '/admin.php', [
            'title' => 'Admin | Accueil',
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Update about
     */
    #[Route('/admin/about', name: 'about')]
    public function about()
    {
        $ContentsTable = new Contents();
        $ContentsTable
            ->innerJoin(Pictures::class)
            ->on("contents.img_id = pictures.img_id");
        $contents = $ContentsTable->findAllBy(['contents.page_id' => 6]);

        $form = $this->createForm("", "post", ['class' => 'grid'])
            ->add("id", HiddenType::class)
            ->add("img", HiddenType::class)
            ->add("file", FileType::class, ['class' => 'file', 'label' => 'file', 'id' => uniqid()])
            ->add("subtitle", TextType::class, ['label' => 'Subtitle', 'id' => "subtitle"])
            ->add("text", TextareaType::class, ['label' => 'Text', 'id' => "text"])
            ->add("submit", SubmitType::class, ['value' => 'Save', 'class' => 'btn'])
            ->getForm();

        if ($form->isSubmit()) {
            $error = $form->isXmlValid($ContentsTable);
            if ($error->noError()) {
                if (!isset($_POST['alt'])) {
                    $error->danger("error occured", "error_container");
                } else if (empty($_POST['alt'])) {
                    $error->danger("veuillez remplir le champs description image", "alt");
                } else {
                    $data = $form->getData();

                    if (!empty($data['id'])) {
                        $content = $ContentsTable->findOneBy(['id' => $data['id']]);

                        if ($content) {
                            $old_img = $content->getJoin(Pictures::class)->getSrc();
                            $imgs = $ContentsTable->getJoin(Pictures::class)->findAllby(['pictures.src' => $old_img]);

                            $uploads_dir = ROOT . '\public\assets\img';
                            if (!empty($data['file']['name'])) {
                                if (count($imgs) <= 1) {
                                    if (file_exists("$uploads_dir\\$old_img")) {
                                        unlink("$uploads_dir\\$old_img");
                                    }
                                }

                                $tmp_name = $data["file"]["tmp_name"];
                                $name = basename($data["file"]["name"]);
                                if (!file_exists("$uploads_dir\\$name")) {
                                    move_uploaded_file($tmp_name, "$uploads_dir\\$name");
                                }
                            }

                            $ContentsTable->getJoin(Pictures::class)
                                ->setImg_id($content->getImg_id())
                                ->setSrc($data["img"])
                                ->setAlt($data['alt'])
                                ->flush();

                            $content
                                ->setSubtitle($data["subtitle"])
                                ->setText($data["text"])
                                ->flush();
                        } else {
                            $error->danger("error occured", "error_container");
                        }
                    } else {
                        $uploads_dir = ROOT . '\public\assets\img';
                        $tmp_name = $data["file"]["tmp_name"];
                        $name = basename($data["file"]["name"]);
                        if (!file_exists("$uploads_dir\\$name")) {
                            move_uploaded_file($tmp_name, "$uploads_dir\\$name");
                        }

                        $ContentsTable->getJoin(Pictures::class)
                            ->setSrc($data["img"])
                            ->setAlt($data['alt'])
                            ->flush();

                        $ContentsTable
                            ->setImg_id($ContentsTable->lastInsertId())
                            ->setSubtitle($data["subtitle"])
                            ->setText($data["text"])
                            ->setPage_id(6)
                            ->flush();
                    }

                    $_SESSION["message"] = $error->success("success");
                    $error->location(URL . "/admin/about", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Contents::class));
        }

        return $this->render('/admin/about.php', '/admin.php', [
            'title' => 'Admin | À propos',
            'contents' => $contents,
            'form' => $form,
        ]);
    }

    /**
     * Update Information
     */
    #[Route('/admin/info', name: 'info')]
    public function info()
    {
        $InfoTable = new Info();
        $info = $InfoTable->findOne();

        $form = $this->createForm("", "post", ['class' => 'grid'])
            ->add("id", HiddenType::class, ['value' => $info->getId()])
            ->add("location", TextType::class, ['value' => $info->getLocation(), 'label' => 'Adresse', 'id' => "location", 'data-req' => true])
            ->add("email", TextType::class, ['value' => $info->getEmail(), 'label' => 'Email', 'id' => "email", 'data-req' => true])
            ->add("num", TextType::class, ['value' => $info->getNum(), 'label' => 'Num', 'id' => "num", 'data-req' => true])
            ->add("facebook", TextType::class, ['value' => $info->getFacebook(), 'label' => 'Lien facebook', 'id' => "facebook", 'data-req' => true])
            ->add("instagram", TextType::class, ['value' => $info->getInstagram(), 'label' => 'Lien instagram', 'id' => "instagram", 'data-req' => true])
            ->add("etp_name", TextType::class, ['value' => $info->getEtp_name(), 'label' => 'Nom de l\'entreprise', 'id' => "etp_name", 'data-req' => true])
            ->add("first_name", TextType::class, ['value' => $info->getFirst_name(), 'label' => 'Prénom', 'id' => "first_name", 'data-req' => true])
            ->add("last_name", TextType::class, ['value' => $info->getLast_name(), 'label' => 'Nom', 'id' => "last_name", 'data-req' => true])
            ->add("statut", TextType::class, ['value' => $info->getStatut(), 'label' => 'Statut de l\'entreprise', 'id' => "statut", 'data-req' => true])
            ->add("immatriculation_number", NumberType::class, ['value' => $info->getImmatriculation_number(), 'label' => 'Numéro d\'immatriculation', 'id' => "immatriculation_number", 'data-req' => true])
            ->add("host_name", TextType::class, ['value' => $info->getHost_name(), 'label' => 'Nom de l\'hébergeur', 'id' => "host_name", 'data-req' => true])
            ->add("host_location", TextType::class, ['value' => $info->getHost_location(), 'label' => 'Adresse de l\'hébergeur', 'id' => "host_location", 'data-req' => true])
            ->add("host_number", TextType::class, ['value' => $info->getHost_number(), 'label' => 'Numéro de l\'hébergeur', 'id' => "host_number", 'data-req' => true])
            ->add("submit", SubmitType::class, ['value' => 'Save', 'class' => 'btn'])
            ->getForm();

        if ($form->isSubmit()) {
            $error = $form->isXmlValid($InfoTable);
            if ($error->noError()) {
                $data = $form->getData();

                $info
                    ->setLocation($data['location'])
                    ->setEmail($data['email'])
                    ->setNum($data['num'])
                    ->setFacebook($data['facebook'])
                    ->setInstagram($data['instagram'])
                    ->setEtp_name($data['etp_name'])
                    ->setFirst_name($data['first_name'])
                    ->setLast_name($data['last_name'])
                    ->setStatut($data['statut'])
                    ->setImmatriculation_number($data['immatriculation_number'])
                    ->setHost_name($data['host_name'])
                    ->setHost_location($data['host_location'])
                    ->setHost_number($data['host_number'])
                    ->flush();

                $_SESSION["message"] = $error->success("success");
                $error->location(URL . "/admin/info", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Info::class));
        }

        return $this->render('/admin/home.php', '/admin.php', [
            'title' => 'Admin | Info',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Show all categorys
     */
    #[Route('/admin/projects-categorie', name: 'projects_categorie')]
    public function projectsCategory(): Response
    {
        $ProjectCategorysTable = new ProjectCategorys();
        $ProjectCategorysTable
            ->innerJoin(Pictures::class)
            ->on("project_categorys.img_id = pictures.img_id");
        $projectCategorys = $ProjectCategorysTable->findAll();

        $formBuilder = $this->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'Supprimer', 'class' => 'del btn'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($ProjectCategorysTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                $ProjectsTable = new Projects();
                $ProjectsTable
                    ->innerJoin(Pages::class)
                    ->on("projects.page_id = pages.page_id")
                    ->innerJoin(Pictures::class)
                    ->on("projects.img_id = pictures.img_id");
                $projects = $ProjectsTable->findAllBy(['category_id' => $data['id']]);

                foreach ($projects as $project) {
                    $ContentsTable = new Contents();
                    $ContentsTable
                        ->innerJoin(Pictures::class)
                        ->on("contents.img_id = pictures.img_id");

                    $contents = $ContentsTable->findAllBy(['contents.page_id' => $project->getPage_id()]);

                    foreach ($contents as $content) {
                        $old_img = $content->getJoin(Pictures::class)->getSrc();

                        $ContentsTable->delete(['id' => $content->getId()]);
                        $ContentsTable->getJoin(Pictures::class)->delete(['img_id' => $content->getImg_id()]);

                        $imgs = $ProjectsTable->getJoin(Pictures::class)->findAllby(['pictures.src' => $old_img]);

                        if (count($imgs) <= 1) {
                            unlink(ROOT . "/public/assets/img/" . $old_img);
                        }
                    }

                    $old_img = $project->getJoin(Pictures::class)->getSrc();
                    $old_id = $project->getImg_id();

                    $imgs = $ProjectsTable->getJoin(Pictures::class)->findAllby(['pictures.src' => $old_img]);

                    $ProjectsTable->delete(['projects.id' => $project->getId()]);
                    $ProjectsTable->getJoin(Pages::class)->delete(['pages.page_id' => $project->getPage_id()]);
                    $ProjectsTable->getJoin(Pictures::class)->delete(['pictures.img_id' => $old_id]);

                    if (count($imgs)  <= 1) {
                        unlink(ROOT . "/public/assets/img/" . $old_img);
                    }
                }

                $projectCategory = $ProjectCategorysTable->findOneBy(['id' => $data['id']]);

                $old_img = $projectCategory->getJoin(Pictures::class)->getSrc();
                $old_id = $projectCategory->getImg_id();

                $imgs = $ProjectCategorysTable->getJoin(Pictures::class)->findAllby(['pictures.src' => $old_img]);

                $ProjectCategorysTable->delete(['id' => $data['id']]);
                $ProjectCategorysTable->getJoin(Pictures::class)->delete(['pictures.img_id' => $old_id]);

                if (count($imgs)  <= 1) {
                    unlink(ROOT . "/public/assets/img/" . $old_img);
                }


                $_SESSION["message"] = $error->success("success");
                $error->location(URL . "/admin/projects-categorie", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(ProjectCategorys::class));
        }

        return $this->render('/admin/project_categorys.php',  '/admin.php', [
            'title' => 'Admin | Project Categorys ',
            'project_categorys' => $projectCategorys,
            'form' => $formBuilder,
        ]);
    }

    /**
     * Insert new category
     */
    #[Route('/admin/projects-categorie/insert', name: 'projects_categorie-insert')]
    public function projectCategoryInsert()
    {
        $ProjectsCategoriesTable = new ProjectCategorys();

        $formPage = $this->createForm("", "post", ['class' => 'grid'])
            ->add("name", TextType::class, ['label' => 'Name', 'id' => 'name'])
            ->add("img", HiddenType::class)
            ->add("file", FileType::class, ['class' => 'file', 'label' => 'file', 'id' => 'file_categ'])
            ->add("submit", SubmitType::class, ['value' => 'save', 'class' => 'btn'])
            ->getForm();

        if ($formPage->isSubmit()) {
            $error = $formPage->isXmlValid($ProjectsCategoriesTable);
            if ($error->noError()) {
                if (!isset($_POST['alt'])) {
                    $error->danger("error occured", "error_container");
                } else if (empty($_POST['alt'])) {
                    $error->danger("veuillez remplir le champs description image", "alt");
                } else {
                    $data = $formPage->getData();

                    $uploads_dir = ROOT . '\public\assets\img';
                    $tmp_name = $data["file"]["tmp_name"];
                    $name = basename($data["file"]["name"]);
                    if (!file_exists("$uploads_dir\\$name")) {
                        move_uploaded_file($tmp_name, "$uploads_dir\\$name");
                    }

                    $PicturesTable = new Pictures();
                    $PicturesTable
                        ->setSrc($data['img'])
                        ->setAlt($data['alt'])
                        ->flush();

                    $url = $this->createUrl($data['name']);

                    $ProjectsCategoriesTable
                        ->setImg_id($PicturesTable->lastInsertId())
                        ->setName($data['name'])
                        ->setUrl($url)
                        ->flush();

                    $_SESSION["message"] = $error->success("success");
                    $error->location(URL . "/admin/projects-categorie", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(ProjectCategorys::class));
        }

        return $this->render('/admin/project_categorie-insert.php',  '/admin.php', [
            'title' => 'Admin | Project categorie | Insert',
            'formPage' => $formPage->createView(),
        ]);
    }

    /**
     * Update category
     */
    #[Route('/admin/projects-categorie/update/{id}', name: 'projects_categorie-update')]
    public function projectCategorieUpdate(int $id)
    {
        $ProjectCategorysTable = new ProjectCategorys();
        $ProjectCategorysTable
            ->innerJoin(Pictures::class)
            ->on("project_categorys.img_id = pictures.img_id");
        $projectCategory = $ProjectCategorysTable->findOneBy(['id' => $id]);

        $formBuilder = $this->createForm("", "post", ['class' => 'grid'])
            ->add("id", HiddenType::class, ['value' => $id])
            ->add("img", HiddenType::class, [
                'value' => $projectCategory->getJoin(Pictures::class)->getSrc(),
                'html' =>
                '<img src="' . URL . '/assets/img/' . $projectCategory->getJoin(Pictures::class)->getSrc() . '" alt="' . $projectCategory->getJoin(Pictures::class)->getAlt() . '">
                <input name="alt" type="text" placeholder="Description image" class="img_alt" value="' . $projectCategory->getJoin(Pictures::class)->getAlt() . '">
                <span class="del_image btn">delete</span>'
            ])
            ->add("file", FileType::class, ['class' => 'file', 'label' => 'file', 'id' => "file"])
            ->add("name", TextType::class, ['value' => $projectCategory->getName(), 'label' => 'Name', 'id' => "name"])
            ->add("submit", SubmitType::class, ['value' => 'Save', 'class' => 'btn'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($ProjectCategorysTable);
            if ($error->noError()) {
                if (!isset($_POST['alt'])) {
                    $error->danger("error occured", "error_container");
                } else if (empty($_POST['alt'])) {
                    $error->danger("veuillez remplir le champs description image", "alt");
                } else {
                    $data = $formBuilder->getData();
                    $uploads_dir = ROOT . '\public\assets\img';

                    $old_img = $projectCategory->getJoin(Pictures::class)->getSrc();

                    $imgs = $ProjectCategorysTable->getJoin(Pictures::class)->findAllby(['pictures.src' => $old_img]);

                    if (!empty($data['file']['name'])) {
                        if (count($imgs) <= 1) {
                            if (file_exists("$uploads_dir\\$old_img")) {
                                unlink("$uploads_dir\\$old_img");
                            }
                        }

                        $tmp_name = $data["file"]["tmp_name"];
                        $name = basename($data["file"]["name"]);
                        if (!file_exists("$uploads_dir\\$name")) {
                            move_uploaded_file($tmp_name, "$uploads_dir\\$name");
                        }
                    }


                    $ProjectCategorysTable->getJoin(Pictures::class)
                        ->setImg_id($projectCategory->getImg_id())
                        ->setSrc($data["img"])
                        ->setAlt($data['alt'])
                        ->flush();

                    $url = $this->createUrl($data['name']);

                    $projectCategory
                        ->setName($data["name"])
                        ->setUrl($url)
                        ->flush();

                    $_SESSION["message"] = $error->success("success");
                    $error->location(URL . "/admin/projects-categorie", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(ProjectCategorys::class));
        }

        return $this->render('/admin/project_categorie.php',  '/admin.php', [
            'title' => 'Admin | Projects',
            'project_categorie' => $projectCategory,
            'form' => $formBuilder,
        ]);
    }

    /**
     * Show all projects from category
     */
    #[Route('/admin/projects-categorie/{name}', name: 'projects_categorie')]
    public function projectsInCategorie(string $name): Response
    {
        $ProjectCategorysTable = new ProjectCategorys();
        $projectCategorys = $ProjectCategorysTable->findOneBy(['url' =>  $name]);

        if (!$projectCategorys) {
            $this->headLocation("/admin/projects-categorie");
        }

        $ProjectsTable = new Projects();
        $ProjectsTable
            ->innerJoin(Pictures::class)
            ->on("projects.img_id = pictures.img_id")
            ->innerJoin(Pages::class)
            ->on("projects.page_id = pages.page_id");

        $projects = $ProjectsTable->findAllBy(['projects.category_id' =>  $projectCategorys->getId()]);

        $formBuilder = $this->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'Supprimer', 'class' => 'del btn'])
            ->getForm();

        if ($formBuilder->isSubmit()) {
            $error = $formBuilder->isXmlValid($ProjectsTable);
            if ($error->noError()) {
                $data = $formBuilder->getData();

                $project = $ProjectsTable->findOneBy(['projects.id' => $data['id']]);

                if ($project) {
                    $ContentsTable = new Contents();
                    $ContentsTable
                        ->innerJoin(Pictures::class)
                        ->on("contents.img_id = pictures.img_id");

                    $contents = $ContentsTable->findAllBy(['contents.page_id' => $project->getPage_id()]);

                    foreach ($contents as $content) {
                        $old_img = $content->getJoin(Pictures::class)->getSrc();

                        $ContentsTable->delete(['id' => $content->getId()]);
                        $ContentsTable->getJoin(Pictures::class)->delete(['img_id' => $content->getImg_id()]);

                        $imgs = $ProjectsTable->getJoin(Pictures::class)->findAllby(['pictures.src' => $old_img]);

                        if (count($imgs) <= 1) {
                            unlink(ROOT . "/public/assets/img/" . $old_img);
                        }
                    }

                    $old_img = $project->getJoin(Pictures::class)->getSrc();
                    $old_id = $project->getImg_id();

                    $imgs = $ProjectsTable->getJoin(Pictures::class)->findAllby(['pictures.src' => $old_img]);

                    $ProjectsTable->delete(['projects.id' => $data['id']]);
                    $ProjectsTable->getJoin(Pages::class)->delete(['pages.page_id' => $project->getPage_id()]);
                    $ProjectsTable->getJoin(Pictures::class)->delete(['pictures.img_id' => $old_id]);

                    if (count($imgs)  <= 1) {
                        unlink(ROOT . "/public/assets/img/" . $old_img);
                    }

                    $_SESSION["message"] = $error->success("success");
                    $error->location(URL . "/admin/projects-categorie/$name", "success_location");
                } else {
                    $error->danger("error occured", "error_container");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Projects::class));
        }

        return $this->render('/admin/categories.php',  '/admin.php', [
            'title' => $projectCategorys->getName(),
            'project_categorie' => $projectCategorys,
            'projects' => $projects,
            'form' => $formBuilder,
        ]);
    }

    /**
     * Insert project
     */
    #[Route('/admin/projects/insert', name: 'project_insert')]
    public function projectInsert()
    {
        $ProjectsTable = new Projects();
        $ProjectCategorysTable = new ProjectCategorys();
        $projectCategorys = $ProjectCategorysTable->findAll();

        $choice_category = [];
        foreach ($projectCategorys as $category) {
            $choice_category[$category->getName()] = $category->getId();
        };

        $formPage = $this->createForm("", "post", ['class' => 'grid'])
            ->add("title", TextType::class, ['label' => 'Title', 'id' => 'title'])
            ->add("categorie", ChoiceType::class, ['choices' => $choice_category, 'label' => 'Catégorie', 'id' => 'categorie'])
            ->add("img", HiddenType::class)
            ->add("file", FileType::class, ['class' => 'file', 'label' => 'file', 'id' => 'file_page'])
            ->add("submit", SubmitType::class, ['value' => 'save', 'class' => 'btn'])
            ->getForm();

        if ($formPage->isSubmit()) {
            $error = $formPage->isXmlValid($ProjectsTable);
            if ($error->noError()) {
                if (!isset($_POST['alt'])) {
                    $error->danger("error occured", "error_container");
                } else if (empty($_POST['alt'])) {
                    $error->danger("veuillez remplir le champs description image", "alt");
                } else {
                    $data = $formPage->getData();

                    $uploads_dir = ROOT . '\public\assets\img';
                    $tmp_name = $data["file"]["tmp_name"];
                    $name = basename($data["file"]["name"]);
                    if (!file_exists("$uploads_dir\\$name")) {
                        move_uploaded_file($tmp_name, "$uploads_dir\\$name");
                    }

                    $PicturesTable = new Pictures();
                    $PicturesTable
                        ->setSrc($name)
                        ->setAlt($data['alt'])
                        ->flush();

                    $img_id = $PicturesTable->lastInsertId();

                    $PagesTable = new Pages();

                    $url = $this->createUrl($data['title']);

                    $PagesTable
                        ->setTitle($data['title'])
                        ->setName($data["title"])
                        ->setUrl($url)
                        ->flush();

                    $ProjectsTable
                        ->setCategory_id($data['categorie'])
                        ->setPage_id($PagesTable->lastInsertId())
                        ->setImg_id($img_id)
                        ->flush();

                    $category = $ProjectCategorysTable->findOneBy(['id' => $data['categorie']]);

                    $_SESSION["message"] = $error->success("success");
                    $error->location(URL . "/admin/projects-categorie/" . $category->getUrl(), "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Projects::class));
        }

        return $this->render('/admin/project_categorie-insert.php',  '/admin.php', [
            'title' => 'Admin | Project categorie | Insert',
            'formPage' => $formPage->createView(),
        ]);
    }

    /**
     * Update project
     */
    #[Route('/admin/projects/{categorie}/{name}/update', name: 'project_update')]
    public function projectUpdate(string $categorie, string $name)
    {
        $ProjectsTable = new Projects();
        $ProjectsTable
            ->innerJoin(Pictures::class)
            ->on("projects.img_id = pictures.img_id")
            ->innerJoin(Pages::class)
            ->on("projects.page_id = pages.page_id");

        $project = $ProjectsTable->findOneBy(['pages.url' =>  $name]);

        if (!$project) {
            $this->headLocation("/admin/projects-categorie/$categorie");
        }

        $ProjectsCategorysTable = new ProjectCategorys();
        $projectCategorys = $ProjectsCategorysTable->findAll();

        $choice_category = [];
        foreach ($projectCategorys as $category) {
            $choice_category[$category->getName()] = $category->getId();
        };

        $formPage = $this->createForm("", "post", ['class' => 'grid'])
            ->add("id", HiddenType::class, ['value' => $project->getId()])
            ->add("title", TextType::class, ['value' => $project->getJoin(Pages::class)->getTitle(), 'label' => 'Title', 'id' => 'title'])
            ->add("categorie", ChoiceType::class, ['choices' => $choice_category, 'value' => $project->getCategory_id(), 'label' => 'Catégorie', 'id' => 'categorie'])
            ->add("img", HiddenType::class, [
                'value' => $project->getJoin(Pictures::class)->getSrc(),
                'html' =>
                '<img src="' . URL . '/assets/img/' . $project->getJoin(Pictures::class)->getSrc() . '" alt="' . $project->getJoin(Pictures::class)->getAlt() . '">
                <input name="alt" type="text" placeholder="Description image" class="img_alt" value="' . $project->getJoin(Pictures::class)->getAlt() . '">
                <span class="del_image btn">delete</span>'
            ])
            ->add("file", FileType::class, ['class' => 'file', 'label' => 'file', 'id' => 'file_page'])
            ->add("submit", SubmitType::class, ['value' => 'save', 'class' => 'btn'])
            ->getForm();

        if ($formPage->isSubmit()) {
            if (isset($_POST['title'])) {
                $error = $formPage->isXmlValid($ProjectsTable);
                if ($error->noError()) {
                    if (!isset($_POST['alt'])) {
                        $error->danger("error occured", "error_container");
                    } else if (empty($_POST['alt'])) {
                        $error->danger("veuillez remplir le champs description image", "alt");
                    } else {
                        $data = $formPage->getData();
                        $uploads_dir = ROOT . '\public\assets\img';

                        $old_img = $project->getJoin(Pictures::class)->getSrc();

                        $imgs = $ProjectsTable->getJoin(Pictures::class)->findAllby(['pictures.src' => $old_img]);

                        if (!empty($data['file']['name'])) {
                            if (count($imgs) <= 1) {
                                if (file_exists("$uploads_dir\\$old_img")) {
                                    unlink("$uploads_dir\\$old_img");
                                }
                            }

                            $tmp_name = $data["file"]["tmp_name"];
                            $img_name = basename($data["file"]["name"]);
                            if (!file_exists("$uploads_dir\\$img_name")) {
                                move_uploaded_file($tmp_name, "$uploads_dir\\$img_name");
                            }
                        }

                        $ProjectsTable->getJoin(Pictures::class)
                            ->setImg_id($project->getImg_id())
                            ->setSrc($data["img"])
                            ->setAlt($data['alt'])
                            ->flush();

                        $url = $this->createUrl($data['title']);

                        $project->getJoin(Pages::class)
                            ->setPage_id($project->getPage_id())
                            ->setTitle($data['title'])
                            ->setName($data["title"])
                            ->setUrl($url)
                            ->flush();

                        $project
                            ->setCategory_id($data['categorie'])
                            ->flush();

                        $_SESSION["message"] = $error->success("success");
                        $error->location(URL . "/admin/projects/$categorie/$name/update", "success_location");
                    }
                }
                $error->getXmlMessage($this->app->getProperties(Projects::class));
            }
        }

        $ContentTable = new Contents();
        $ContentTable
            ->innerJoin(Pictures::class)
            ->on("contents.img_id = pictures.img_id");
        $contents = $ContentTable->findAllBy(['page_id' =>  $project->getPage_id()]);

        $formContent = $this->createForm("", "post", ['class' => 'grid'])
            ->add("id", HiddenType::class)
            ->add("subtitle", TextType::class)
            ->add("img", HiddenType::class)
            ->add("file", FileType::class)
            ->add("text", TextareaType::class)
            ->add("submit", SubmitType::class, ['class' => 'btn', 'value' => 'save'])
            ->getForm();

        if ($formContent->isSubmit()) {
            if ($_POST['subtitle']) {
                $error = $formContent->isXmlValid($ContentTable);
                if ($error->noError()) {
                    $data = $formContent->getData();
                    if (!isset($_POST['alt'])) {
                        $error->danger("error occured", "error_container");
                    } else if (empty($_POST['alt'])) {
                        $error->danger("veuillez remplir le champs description image", "alt");
                    } else {
                        $uploads_dir = ROOT . '\public\assets\img';

                        if (isset($data["id"]) && !empty($data["id"])) {
                            $content =  $ContentTable->findOneby(['id' => $data['id']]);

                            $old_img = $content->getJoin(Pictures::class)->getSrc();

                            $imgs = $ContentTable->getJoin(Pictures::class)->findAllby(['pictures.src' => $old_img]);

                            if (!empty($data['file']['name'])) {
                                if (count($imgs) <= 1) {
                                    if (file_exists("$uploads_dir\\$old_img")) {
                                        unlink("$uploads_dir\\$old_img");
                                    }
                                }

                                $tmp_name = $data["file"]["tmp_name"];
                                $img_name = basename($data["file"]["name"]);
                                if (!file_exists("$uploads_dir\\$img_name")) {
                                    move_uploaded_file($tmp_name, "$uploads_dir\\$img_name");
                                }
                            }
                            $content->getJoin(Pictures::class)
                                ->setImg_id($content->getImg_id())
                                ->setSrc($data["img"])
                                ->setAlt($data['alt'])
                                ->flush();

                            $content
                                ->setSubtitle($data['subtitle'])
                                ->setText($data["text"])
                                ->flush();
                        } else {
                            $tmp_name = $data["file"]["tmp_name"];
                            $img_name = basename($data["file"]["name"]);
                            if (!file_exists("$uploads_dir\\$img_name")) {
                                move_uploaded_file($tmp_name, "$uploads_dir\\$img_name");
                            }

                            $ContentTable->getJoin(Pictures::class)
                                ->setSrc($img_name)
                                ->setAlt($data['alt'])
                                ->flush();

                            $img_id = $ContentTable->lastInsertId();

                            $ContentTable
                                ->setSubtitle($data['subtitle'])
                                ->setText($data["text"])
                                ->setImg_id($img_id)
                                ->setPage_id($project->getPage_id())
                                ->flush();
                        }
                        $_SESSION["message"] = $error->success("success");
                        $error->location(URL . "/admin/projects/$categorie/$name/update", "success_location");
                    }
                }
                $error->getXmlMessage($this->app->getProperties(Contents::class));
            }
        }

        return $this->render('/admin/project_update.php',  '/admin.php', [
            'title' => 'Admin | ' . $project->getJoin(Pages::class)->getName(),
            'formPage' => $formPage->createView(),
            'contents' => $contents,
            'formContent' => $formContent
        ]);
    }

    /**
     * Register new admin
     */
    #[Route('/admin/users', name: 'all users')]
    public function allUsers()
    {
        $UsersTable = new Users();
        $users = $UsersTable->findAll();

        $form_delete = $this->createForm()
            ->add("id", HiddenType::class)
            ->add("submit", SubmitType::class, ['value' => 'Supprimer', 'class' => 'btn del'])
            ->getForm();

        if ($form_delete->isSubmit()) {
            $error = $form_delete->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $form_delete->getData();

                if ($UsersTable->findOneBy(['id' => $data['id']])) {
                    $UsersTable->delete(['id' => $data['id']]);

                    $_SESSION["message"] = $error->success("Supprimé avec succès");
                    $error->location(URL . "/admin/users", "success_location");
                } else {
                    $error->danger("erreur survenue", "error_container");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/admin/allusers.php', '/admin.php', [
            'title' => 'All users',
            'users' => $users,
            'form_delete' => $form_delete
        ]);
    }

    /**
     * Register new admin
     */
    #[Route('/admin/register', name: 'insert user')]
    public function register(): Response
    {
        $usersTable = new Users();

        $formBuilder = $this
            ->createForm("", "post", ['class' => 'grid'])
            ->add("email", EmailType::class, ['label' => 'email', 'id' => 'email'])
            ->add("password", PasswordType::class, ['label' => 'mot de passe', 'id' => 'password', 'data-pass' => true])
            ->add("submit", SubmitType::class, ['value' => 'login', 'class' => 'btn'])
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
                    $_SESSION['admin'] = $userid;
                    $_SESSION["message"] = $error->success("account create successfully");
                    $error->location(URL . "/admin/users", "success_location");
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/admin/register.php', '/login.php', [
            'title' => 'Register',
            'form' => $formBuilder->createView(),
        ]);
    }

    #[Route('/admin/users/update/{id}', name: 'update user')]
    public function updateUser(int $id)
    {
        $UsersTable = new Users();
        $user = $UsersTable->findOneBy(['id' => $id]);

        if (!$user) {
            $this->headLocation("/admin/users");
        }

        $form_update = $this->createForm("", "post", ['class' => 'grid'])
            ->add("id", HiddenType::class, ['value' => $id])
            ->add("email", EmailType::class, ['value' => $user->getEmail(), 'label' => 'Email', 'id' => 'email'])
            ->add("new_password", PasswordType::class, ['label' => 'Nouveau mot de passe', 'id' => 'new_password', 'data-pass' => true])
            ->add("old_password", PasswordType::class, ['label' => 'Ancien mot de passe', 'id' => 'old_password'])
            ->add("submit", SubmitType::class, ['value' => 'Save', 'class' => 'btn'])
            ->getForm();

        if ($form_update->isSubmit()) {
            $error = $form_update->isXmlValid($UsersTable);
            if ($error->noError()) {
                $data = $form_update->getData();
                if (password_verify($data['old_password'], $user->getPassword())) {

                    $user
                        ->setPassword(password_hash($data["new_password"], PASSWORD_DEFAULT))
                        ->setEmail($data['email'])
                        ->flush();

                    $_SESSION["message"] = $error->success("Changement sauvegardé");
                    $error->location(URL . "/admin/users", "success_location");
                } else {
                    $error->danger("Mot de passe incorrect", 'error_container');
                }
            }
            $error->getXmlMessage($this->app->getProperties(Users::class));
        }

        return $this->render('/admin/home.php', '/admin.php', [
            'title' => 'Admin | Users | Update',
            'form' => $form_update->createView(),
        ]);
    }

    /**
     * Register new admin
     */
    #[Route('/admin/logout', name: 'logout')]
    public function logout()
    {
        session_start();
        session_destroy();
        $this->headLocation("");
    }
}
