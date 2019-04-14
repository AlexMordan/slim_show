<?php


namespace App\Controller;


use App\Model\Repository\UserRepository;
use App\Model\User;
use Exception;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class UserController extends BaseController
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    public function index(Request $request, Response $response, $args)
    {
        $users = $this->userRepository->findAll();
        $this->view->render($response, "user/index.twig", ['users' => $users]);
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     * @throws Exception
     */
    public function show(Request $request, Response $response, $args)
    {
        try {
            $id = $args['id'];
            $user = $this->entityManager->find(User::class, $id);
            return $this->view->render($response, "user/show.twig", ['user' => $user]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function profile(Request $request, Response $response)
    {
        $user = $this->userRepository->find($this->auth->user()->getId());
        return $this->view->render($response, "user/profile/index.twig", ['user' => $user]);
    }

    public function editProfile(Request $request, Response $response)
    {
        $user = $this->entityManager->find(User::class, $this->auth->user()->getId());
        if ($request->isGet()) {
            return $this->view->render($response, "user/profile/edit.twig", ['user' => $user]);
        }
        /** * @var UploadedFile[] $uploadedFiles */
        $uploadedFiles = $request->getUploadedFiles();
        if (!empty($uploadedFiles['inputAvatar'])) {
            $directory = '../public/' . getenv('UPLOAD_DIR');
            $uploadedFile = $uploadedFiles['inputAvatar'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = $this->moveUploadedFile($directory, $uploadedFile);
                $user->setAvatar('/' . getenv('UPLOAD_DIR') . '/' . $filename);
            }
        }

        //TODO: update another property

        $this->entityManager->flush();
        return $response->withRedirect('/users/profile');
    }

}