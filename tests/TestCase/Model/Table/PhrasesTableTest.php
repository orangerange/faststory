<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PhrasesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PhrasesTable Test Case
 */
class PhrasesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PhrasesTable
     */
    public $Phrases;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.phrases',
        'app.contents',
        'app.chapters',
        'app.characters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Phrases') ? [] : ['className' => PhrasesTable::class];
        $this->Phrases = TableRegistry::getTableLocator()->get('Phrases', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Phrases);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
