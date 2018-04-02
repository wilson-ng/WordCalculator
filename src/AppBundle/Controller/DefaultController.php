<?php

namespace AppBundle\Controller;

use AppBundle\Calculator\Calculator;
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
        $minimumCalculateAllowance = 0;
        $maximumCalculateAllowance = 20;

        $result = '';
        $form = $this->createFormBuilder()
                     ->add('stringCalculation', FormType\TextType::class, [
                        'label' => 'Word : ',
                     ])
                     ->add('submit', FormType\SubmitType::class, [
                        'label' => 'Hitung',
                     ])
                     ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $stringTobeCalculate = $form->getData()['stringCalculation'];

            preg_match('/(.*) (tambah|kali|kurang) (.*)/', $stringTobeCalculate, $arrayTobeCalculate);
            if (empty($arrayTobeCalculate)) {
                $this->addFlash('danger', sprintf('Nilai valid sisi kiri dan kanan adalah rentang %d sampai dengan %d.', $minimumCalculateAllowance, $maximumCalculateAllowance));
                $this->addFlash('danger', sprintf('Operator aritmatika yang valid adalah : %s.', implode(', ', ['tambah', 'kurang', 'kali'])));
                return $this->redirectToRoute('homepage');
            }

            $leftSide = $arrayTobeCalculate[1];
            $rightSide = $arrayTobeCalculate[3];
            $operator = $arrayTobeCalculate[2];

            $wordList = array_fill(0, $maximumCalculateAllowance + 1, '');
            foreach ($wordList as $key => &$word) {
                $word = NumberToWordConverter::handle($key); 
            }

            $leftSide = $this->convertStringToNumberFromList($wordList, $leftSide); 
            $rightSide = $this->convertStringToNumberFromList($wordList, $rightSide); 

            if ($leftSide > $maximumCalculateAllowance || $leftSide < $minimumCalculateAllowance || $rightSide > $maximumCalculateAllowance || $rightSide < $minimumCalculateAllowance) {
                $this->addFlash('danger', sprintf('Nilai valid sisi kiri dan kanan adalah rentang %d sampai dengan %d.', $minimumCalculateAllowance, $maximumCalculateAllowance));
                return $this->redirectToRoute('homepage');
            }
            if (!Calculator::canCalculate($operator)) {
                $this->addFlash('danger', sprintf('Operator aritmatika yang valid adalah : %s.'. implode(', ', ['tambah', 'kurang', 'kali'])));
                return $this->redirectToRoute('homepage');
            }

            $calculateResult = Calculator::calculate($leftSide, $rightSide, $operator);

            $result = sprintf(
                '%s adalah %s%s', 
                $arrayTobeCalculate[0], 
                $calculateResult < 0 ? 'minus ' : '', 
                NumberToWordConverter::handle(abs($calculateResult))
            );
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
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
