<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\DTO\LowestPriceEnquiry;
use App\Service\Serializer\DTOSerializer;

class ProductsController extends AbstractController {

    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: ['GET'])]
    public function lowestPrice ( Request $request, int $id, DTOSerializer $serializer ): Response{
        //dd ( $id );
        
        if ( $request->headers->has('force_fail')) {
            return new JsonResponse (
                ['error' => 'Promotions Engine failure message',],
                $request->headers->get('force_fail')
            );
        }

        //dd($serializer);
    
        // 1. Deserialize json data into a EnquiryDTO
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json');
        
        //dd($lowestPriceEnquiry);
        
        // 2. Pass the Enquiry (Anfrage) into a promotions filter
            // the appropriate (entsprechende) promotion will be applied (angewendet)
        


        // 3. Return the modified Enquiry
        $lowestPriceEnquiry->setDiscountedPrice(50);
        $lowestPriceEnquiry->setPrice(100);
        $lowestPriceEnquiry->setPromotionId(3);
        $lowestPriceEnquiry->setPromotionName('Black Friday half price sale');
        
        $responseContent = $serializer->serialize($lowestPriceEnquiry, 'json' );
        
        return new Response($responseContent, 200);
    }








    #[Route('/products/{id}/promotions', name: 'promotions', methods: 'GET')]
    public function promotions (): JsonResponse {


        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProductsController.php',
        ]);
    }
}
