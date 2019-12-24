<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use App\Form\PlaceType;
use App\Entity\Place;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;


class PlaceController extends AbstractController
{
    /**
     * Crée un lieu dans l'application
     * @Rest\View(statusCode=Response::HTTP_CREATED,serializerGroups={"place"})
     * @SWG\Response(
     *     response=201,
     *     description="Création avec succès",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Place::class, groups={"place"}))
     *     )
     * )
 * @SWG\Response(
     *     response=400,
     *     description="Formulaire invalide",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=PlaceType::class))
     *     )
     * )
     */
    public function postPlacesAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();;
            $em->persist($place);
            $em->flush();
            return $place;
        } else {
            return $form;
        }
    }
     /**
     * lister les lieux
     * @Rest\View(serializerGroups={"place"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Récupère la liste des lieux de l'application",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Place::class, groups={"place"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="order",
     *     in="query",
     *     type="string",
     *     description="le champs utiliser pour afficher la liste des lieux"
     * )
     *  * @SWG\Tag(name="places")
     * @Security(name="Bearer")
     */
    public function getPlacesAction(Request $request)
    {
        $places = $this->getdoctrine()->getManager()
                ->getRepository(Place::class)
                ->findAll();
        /* @var $places Place[] */

        return $places;
    }
     /**
     * @Rest\View(serializerGroups={"place"}))
     * @Rest\Get("/places/{id}")
     */
    public function getPlaceAction(Request $request)
    {
        $place = $this->getdoctrine()->getManager()
                ->getRepository(Place::class)
                ->find($request->get('id')); // L'identifiant en tant que paramétre n'est plus nécessaire
        /* @var $place Place */

        if (empty($place)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $place;
    }
      /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT,serializerGroups={"place"})
     * @Rest\Delete("/places/{id}")
     */
    public function removePlaceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $place = $em->getRepository(Place::class)->find($request->get('id'));
        /* @var $place Place */
        if ($place) {
            $em->remove($place);
            $em->flush();
        }

    
    }
    /**
     * @Rest\View(serializerGroups={"place"})
     * @Rest\Put("/places/{id}")
     */
    public function updatePlaceAction(Request $request)
    {
        return $this->updatePlace($request, true);
    }

    /**
     * @Rest\View(serializerGroups={"place"})
     * @Rest\Patch("/places/{id}")
     */
    public function patchPlaceAction(Request $request)
    {
        return $this->updatePlace($request, false);
    }

    private function updatePlace(Request $request, $clearMissing)
    {
        $place = $this->getdoctrine()->getManager()
                ->getRepository(Place::class)
                ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $place Place */

        if (empty($place)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PlaceType::class, $place);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->getdoctrine()->getManager();
            $em->persist($place);
            $em->flush();
            return $place;
        } else {
            return $form;
        }
    }
}