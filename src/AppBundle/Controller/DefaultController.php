<?php

namespace AppBundle\Controller;

use AppBundle\Converter\NumberToWordConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type as FormType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
                     ->add('stringCalculation', FormType\TextType::class)
                     ->add('submit', FormType\SubmitType::class)
                     ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $stringTobeCalculate = $form->getData()['stringCalculation'];

            preg_match('/(.*) (tambah|kali|kurang) (.*)/', $stringTobeCalculate, $arrayTobeCalculate);

            $leftSide = $arrayTobeCalculate[1];
            $rightSide = $arrayTobeCalculate[3];
            $operator = $arrayTobeCalculate[2];

            $wordList = array_fill(1, 20, '');
            foreach ($wordList as $key => &$word) {
                $word = NumberToWordConverter::handle($key); 
            }
            $wordList = array_merge([0 => 'nol'], $wordList);

            $leftSide = $this->convertStringToNumberFromList($wordList, $leftSide); 
            $rightSide = $this->convertStringToNumberFromList($wordList, $rightSide); 

            if ($leftSide > 20 || $leftSide < 0 || $rightSide > 20 || $rightSide < 0) {
                $this->addFlash('notice', 'Nilai valid sisi kiri dan kanan adalah rentang 0 sampai dengan 20.');
                return $this->redirectToRoute('homepage');
            }

        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function convertStringToNumberFromList(array $list, String $word): int
    {
        if (!in_array($word, $list)) {
            return -1;
        }
        return array_search($word, $list);
    }
}
