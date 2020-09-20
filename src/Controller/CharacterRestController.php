<?php
// src/Controller/CharacterRestController.php

namespace App\Controller;

use App\Entity\Character;
use App\Model\CharacterResponse;
use App\Model\Response as BaseResponse;
use App\Utils\Controller\AbstractCharacterRestController;
use App\Utils\Interfaces\CRUDInterface;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Route;
use Knp\Component\Pager\PaginatorInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/v1")
 */
class CharacterRestController extends AbstractCharacterRestController implements CRUDInterface
{
    /**
     * CharacterRestController constructor
     *
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        parent::__construct($entityManager, $paginator);
    }

    /**
     * Lists all Star Wars characters
     *
     * @Get("/character", name="api_character_index", options={"method_prefix" = false})
     *
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="Page number to return"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns paginated list of Star Wars characters",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="characters",
     *             type="array",
     *             @SWG\Items(
     *                 type="object",
     *                 @SWG\Property(property="id", type="integer"),
     *                 @SWG\Property(property="name", type="string"),
     *                 @SWG\Property(property="episodes", type="array", @SWG\Items(type="string")),
     *                 @SWG\Property(property="planet", type="string"),
     *                 @SWG\Property(property="friends", type="array", @SWG\Items(type="string")),
     *             ),
     *         ),
     *         @SWG\Property(
     *             property="pagination",
     *             type="object",
     *         ),
     *     ),
     * )
     *
     * @SWG\Tag(name="Character")
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page', 1);

        $queryBuilder = $this->getQueryBuilder('App:Character', 'c');

        $pagination = $this->paginator->paginate($queryBuilder, $page, 5);

        $data = [
            'characters' => $pagination->getItems(),
            'pagination' => $pagination->getPaginationData(),
        ];

        return $this->handleResponse($data);
    }

    /**
     * Create new Star Wars character
     *
     * @Post("/character", name="api_character_create", options={"method_prefix" = false})
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string"),
     *         @SWG\Property(property="episodes", type="array", @SWG\Items(type="string")),
     *         @SWG\Property(property="planet", type="string"),
     *         @SWG\Property(property="friends", type="array", @SWG\Items(type="string")),
     *     ),
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns created Star Wars character",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="character",
     *             type="object",
     *             @SWG\Property(property="id", type="integer"),
     *             @SWG\Property(property="name", type="string"),
     *             @SWG\Property(property="episodes", type="array", @SWG\Items(type="string")),
     *             @SWG\Property(property="planet", type="string"),
     *             @SWG\Property(property="friends", type="array", @SWG\Items(type="string")),
     *         ),
     *         @SWG\Property(property="result", type="string"),
     *     ),
     * )
     *
     * @SWG\Tag(name="Character")
     *
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $name = $request->get('name', '');

        $response = new CharacterResponse();

        if (empty($name)) {
            $response->setResult('ERROR');;
        }
        else {
            $episodes = $request->get('episodes', []);
            $planet = $request->get('planet', '');
            $friends = $request->get('friends', []);

            $character = $this->getEntity(Character::class, ['name' => $name]);

            if (!$character) {
                $character = new Character();

                $this->updateCharacter($character, $name, $episodes, $planet, $friends);

                $this->persistEntity($character);

                $response->setCharacter($character);
                $response->setResult('SUCCESS');
            }
            else {
                $response->setResult('ERROR');;
            }
        }

        return $this->handleResponse($response);
    }

    /**
     * Get specified Star Wars character
     *
     * @Get("/character/{id}", name="api_character_read", options={"method_prefix" = false})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns Star Wars character",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="character",
     *             type="object",
     *             @SWG\Property(property="id", type="integer"),
     *             @SWG\Property(property="name", type="string"),
     *             @SWG\Property(property="episodes", type="array", @SWG\Items(type="string")),
     *             @SWG\Property(property="planet", type="string"),
     *             @SWG\Property(property="friends", type="array", @SWG\Items(type="string")),
     *         ),
     *         @SWG\Property(property="result", type="string"),
     *     ),
     * )
     *
     * @SWG\Tag(name="Character")
     *
     * @param Request $request
     * @return Response
     */
    public function readAction(Request $request)
    {
        $id = $request->get('id', 0);

        $response = new CharacterResponse();

        if (!empty($id)) {
            $character = $this->getEntity(Character::class, ['id' => $id]);

            if (!$character) {
                $response->setResult('ERROR');
            }
            else {
                $response->setCharacter($character);
                $response->setResult('SUCCESS');
            }
        }
        else {
            $response->setResult('ERROR');
        }

        return $this->handleResponse($response);
    }

    /**
     * Update specified Star Wars character
     *
     * @Put("/character/{id}", name="api_character_update", options={"method_prefix" = false})
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string"),
     *         @SWG\Property(property="episodes", type="array", @SWG\Items(type="string")),
     *         @SWG\Property(property="planet", type="string"),
     *         @SWG\Property(property="friends", type="array", @SWG\Items(type="string")),
     *     ),
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns updated Star Wars character",
     *    @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="character",
     *             type="object",
     *             @SWG\Property(property="id", type="integer"),
     *             @SWG\Property(property="name", type="string"),
     *             @SWG\Property(property="episodes", type="array", @SWG\Items(type="string")),
     *             @SWG\Property(property="planet", type="string"),
     *             @SWG\Property(property="friends", type="array", @SWG\Items(type="string")),
     *         ),
     *         @SWG\Property(property="result", type="string"),
     *     ),
     * )
     *
     * @SWG\Tag(name="Character")
     *
     * @param Request $request
     * @return Response
     */
    public function updateAction(Request $request)
    {
        $id = $request->get('id');

        $response = new CharacterResponse();

        if (!empty($id)) {
            /** @var Character $character */
            $character = $this->getEntity(Character::class, ['id' => $id]);

            if (!$character) {
                $response->setResult('ERROR');
            }
            else {
                $name = $request->get('name', $character->getName());
                $episodes = $request->get('episodes', []);
                $planet = $request->get('planet', '');
                $friends = $request->get('friends', []);

                $this->updateCharacter($character, $name, $episodes, $planet, $friends);

                $this->entityManager->flush();

                $response->setCharacter($character);
                $response->setResult('SUCCESS');
            }
        }
        else {
            $response->setResult('ERROR');
        }

        return $this->handleResponse($response);
    }

    /**
     * Delete specified Star Wars character
     *
     * @Delete("/character/{id}", name="api_character_delete", options={"method_prefix" = false})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns operation result",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="result", type="string"),
     *     ),
     * )
     *
     * @SWG\Tag(name="Character")
     *
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request)
    {
        $id = $request->get('id', 0);

        $response = new BaseResponse();

        if (!empty($id)) {
            /** @var Character $character */
            $character = $this->getEntity(Character::class, ['id' => $id]);

            if (!$character) {
                $response->setResult('ERROR');
            }
            else {
                $this->removeEntity($character);

                $response->setResult('SUCCESS');
            }
        }
        else {
            $response->setResult('ERROR');
        }

        return $this->handleResponse($response);
    }
}
