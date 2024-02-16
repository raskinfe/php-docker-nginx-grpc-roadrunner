<?php

namespace App\Controllers;

use App\Core\Request;
use Doctrine\ORM\EntityManager;
use App\Models\Note;
use App\Services\View;

class NoteController extends BaseController {

    public function index(EntityManager $em) 
    {
        $notes = $em->getRepository(Note::class)->findAll() ?? [];
        return View::make("notes.notes", [
            'notes' => $notes
        ]);
    }

    public function get(EntityManager $em, Request $request) 
    {
        try {

            $id = $request->get('id');
            $note = $em->getRepository(Note::class)->find($id);
            return View::make("notes.edit", [
                'note' => $note
            ]);

        } catch (\Exception $e) {

        }
    }
    public function create(EntityManager $entityManager, Request $request) 
    {
        $note = new Note();
        $user = $_SESSION['user']['user'];
        $user = $entityManager->getRepository('App\Models\User')->find($user->getId());
        try {
            $note->setAuthor($user)
                ->setContent($request->get('content'))
                ->setDate(new \DateTime());
            $entityManager->persist($note);
            $entityManager->flush();
            header('HTTP/1.1 201 Created');
            echo(json_encode(array('message' => 'Created successfully')));
        } catch (\Exception $e) {
            header('HTTP/1.1 400 Bad request');
            echo(json_encode(array('message' => json_decode(json_encode($e->getMessage())), 'request' => $request)));        }
    }

    public function update(EntityManager $em, Request $request) {
        try {

            $id = $request->get('id');
            $note = $em->getRepository(Note::class)->find($id);

            if( !$note ) { 
                throw new \Exception('Note not found;');
            }

            if (currentUser() === null ) {
               $this->redirect('/');
            }

            if (currentUser()->getId() !== $note->getAuthor()->getId()) { 
                return View::make('notes.notes', [
                    'error' => 'Permission denied',
                ]);
            }

            $note->setContent($request->get('content'));
            $note->setDate(new \DateTime());
            $em->persist($note);
            $em->flush();
            $this->redirect('/notes');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function destroy(EntityManager $em, Request $request) {
        try {

            $id = $request->get('id');
            $note = $em->getRepository(Note::class)->find($id);

            if( !$note ) { 
                throw new \Exception('Note not found;');
            }

            if (currentUser() === null ) {
               $this->redirect('/');
            }

            if (currentUser()->getId() !== $note->getAuthor()->getId()) { 
                return View::make('notes.notes', [
                    'error' => 'Permission denied',
                ]);
            }

            $em->remove($note);
            $em->flush();
            $this->redirect('/notes');

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

}