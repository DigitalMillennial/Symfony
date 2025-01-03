<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends AbstractController
{
    private $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Contact $message */
            $message = $form->getData();

            // Сохранение данных в БД
            $entityManager->persist($message);
            $entityManager->flush();


            try {
                // $mailer->send($email);
                // Отправка письма через MailService
                $this->mailService->sendMail(
                    'hello@example.com',       // Получатель
                    $message->getEmail(),      // Отправитель
                    $message->getObjet(),      // Тема письма
                    $message->getMessage()     // Текст сообщения
                );
            } catch (Exception $e) {
                echo $e->getMessage();
                // error message or try to resend the message

            }


            $this->addFlash('success', 'Votre message a bien été envoyé!');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
