<?php

namespace App\Controller\API;

use App\Entity\Movie;
use App\Form\Type\MovieFormType;
use App\Model\RequestModel;
use App\Repository\MovieRepository;
use App\Service\DateTimeHelper;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MovieController.
 */
class MovieController extends AbstractFOSRestController
{
    /**
     * @Operation(
     *     tags={"Movies"},
     *     summary="Gets list of the companies",
     *     @SWG\Parameter(
     *         name="genre",
     *         in="query",
     *         description="Genre",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="title",
     *         in="query",
     *         required=false,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned on success"
     *     )
     * )
     * @Rest\Get("/movies", name="api_movies_all")
     * @Rest\Get("/movies/week/{week}", name="api_movies_by_week", requirements={"week":"\d{1,33}"})
     *
     * @QueryParam(name="title",strict=true, nullable=true)
     * @QueryParam(name="genre",strict=true, nullable=true)
     *
     * @return \App\Entity\Movie[]
     */
    public function getMovies(int $week = null, MovieRepository $repository, DateTimeHelper $dateTimeHelper, ParamFetcher $paramFetcher): array
    {
        [$weekStart, $weekEnd] = $dateTimeHelper->getStartStopDateByWeekNumber($week);
        $model                 = new RequestModel($paramFetcher->get('title'), $paramFetcher->get('genre'), $weekStart, $weekEnd);

        return $repository->searchByRequestModel($model);
    }

    /**
     * @Operation(
     *     tags={"Movies"},
     *     summary="Creates new movie",
     *     @SWG\Parameter(
     *         name="movie",
     *         in="body",
     *         required=true,
     *         type="object",
     *         @Model(type=MovieFormType::class)
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Returned on success"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when invalid request payload provided"
     *     )
     * )
     * @Rest\Post("/movies/create", name="api_movies_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        return $this->processMovieForm(new Movie(), $request, $em);
    }

    /**
     * @Operation(
     *     tags={"Movies"},
     *     summary="Creates new movie",
     *     @SWG\Parameter(
     *         name="movie",
     *         in="body",
     *         required=true,
     *         type="object",
     *         @Model(type=MovieFormType::class)
     *     ),
     *     @SWG\Response(
     *         response="204",
     *         description="Returned on success"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when invalid request payload provided"
     *     )
     * )
     * @Rest\Patch("/movies/{movie}/edit", requirements={"movie":"\d+"}, name="api_movies_edit")
     * @ParamConverter("movie", class="App\Entity\Movie")
     *
     * @param Movie                  $movie
     * @param Request                $request
     * @param EntityManagerInterface $em
     *
     * @return Response
     */
    public function edit(Movie $movie, Request $request, EntityManagerInterface $em)
    {
        return $this->processMovieForm($movie, $request, $em, false);
    }

    /**
     * @Operation(
     *     tags={"Movies"},
     *     summary="Delete movie",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     *
     * @Rest\Delete("/movies/{movie}/delete", requirements={"movie":"\d+"}, name="api_movies_delete")
     * @ParamConverter("movie", class="App\Entity\Movie")
     */
    public function delete(Movie $movie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->transactional(
            static function () use ($movie, $entityManager) {
                $entityManager->remove($movie);
                $entityManager->flush();
            });

        return $this->handleView($this->view(null, Response::HTTP_OK));
    }

    /**
     * @Operation(
     *     tags={"Movies"},
     *     summary="Get movie",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     *
     * @Rest\Get("/movies/{movie}", requirements={"movie":"\d+"}, name="api_movies_get_one")
     * @ParamConverter("movie", class="App\Entity\Movie")
     *
     * @return Movie
     */
    public function getMovie(Movie $movie): Movie
    {
        return $movie;
    }

    private function processMovieForm(Movie $movie, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(MovieFormType::class, $movie);
        $form->handleRequest($request);
        $data = json_decode($request->getContent(), true);
        $form->submit($data, $request->getMethod() !== 'PATCH');
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($movie);
            $em->flush($movie);

            if ($request->getMethod() === 'PATCH') {
                return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
            }

            return $this->handleView($this->view($movie, Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }
}
