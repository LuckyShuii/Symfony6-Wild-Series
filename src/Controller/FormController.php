<?php

namespace App\Controller;

use App\Form\CategorySelectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\YourFormType;
use App\Repository\CategoryRepository;
use Symfony\Component\BrowserKit\Response;

class FormController extends AbstractController
{
    public function categorySelectForm(Request $request)
    {
        $form = $this->createForm(CategorySelectType::class);
        $form->handleRequest($request);

        return $this->render('components/_category_select_form.html.twig', [
            'form' => $form,
        ]);
    }
}
