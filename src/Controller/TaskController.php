<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index(Request $request)
    {
        $name = $request->get('name');
        $question = $request->get('question');
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $save = $this->getDoctrine()->getManager();
    if (!empty($name && $question))
    {
        $task = new Task();
        $task->setName($name);
        $task->setQuestion($question);

        $save->persist($task);

        $save->flush();
    }


        return $this->render('/task.html.twig', [
            'categories' => $categories,
        ]);
    }
}
