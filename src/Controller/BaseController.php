<?php


namespace App\Controller;

use App\Model\Auth;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Slim\Http\UploadedFile;
use Slim\Views\PhpRenderer;

class BaseController
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var PhpRenderer
     */
    protected $view;
    /**
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * @var Auth
     */
    protected $auth;
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->view = $this->container->get("view");
        $this->entityManager = $this->container->get("entityManager");
        $this->auth = $this->container->get('auth');
    }

    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string $directory directory to which the file is moved
     * @param UploadedFile $uploadedFile
     * @return string filename of moved file
     * @throws \Exception
     */
    protected function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}