<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Phrases Controller
 *
 * @property \App\Model\Table\PhrasesTable $Phrases
 *
 * @method \App\Model\Entity\Phrase[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PhrasesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contents', 'Chapters', 'Characters']
        ];
        $phrases = $this->paginate($this->Phrases);

        $this->set(compact('phrases'));
    }

    /**
     * View method
     *
     * @param string|null $id Phrase id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $phrase = $this->Phrases->get($id, [
            'contain' => ['Contents', 'Chapters', 'Characters']
        ]);
        $this->set('chapterId', $id);
        $this->set('phrase', $phrase);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $phrase = $this->Phrases->newEntity();
        if ($this->request->is('post')) {
            $phrase = $this->Phrases->patchEntity($phrase, $this->request->getData());
            if ($this->Phrases->save($phrase)) {
                $this->Flash->success(__('The phrase has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The phrase could not be saved. Please, try again.'));
        }
        $contents = $this->Phrases->Contents->find('list', ['limit' => 200]);
        $chapters = $this->Phrases->Chapters->find('list', ['limit' => 200]);
        $characters = $this->Phrases->Characters->find('list', ['limit' => 200]);
        $this->set(compact('phrase', 'contents', 'chapters', 'characters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Phrase id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $phrase = $this->Phrases->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $phrase = $this->Phrases->patchEntity($phrase, $this->request->getData());
            if ($this->Phrases->save($phrase)) {
                $this->Flash->success(__('The phrase has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The phrase could not be saved. Please, try again.'));
        }
        $contents = $this->Phrases->Contents->find('list', ['limit' => 200]);
        $chapters = $this->Phrases->Chapters->find('list', ['limit' => 200]);
        $characters = $this->Phrases->Characters->find('list', ['limit' => 200]);
        $this->set(compact('phrase', 'contents', 'chapters', 'characters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Phrase id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $phrase = $this->Phrases->get($id);
        if ($this->Phrases->delete($phrase)) {
            $this->Flash->success(__('The phrase has been deleted.'));
        } else {
            $this->Flash->error(__('The phrase could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
