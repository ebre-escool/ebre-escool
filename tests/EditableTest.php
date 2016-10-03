<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;

/**
 * Class EditableTest.
 */
class EditableTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var string
     */
    protected $tablename = 'users';
    /**
     * @var string
     */
    protected $fieldname = 'name';
    /**
     * @var string
     */
    protected $content = 'Begonya Solé Aragonés';
    /**
     * @var int
     */
    protected $id = 1;

    protected $model = 'App\User';


    /**
     * Test editable save not permitted without user logged
     *
     * @group ok
     * @return void
     */
    public function testEditableSaveNotPermittedWithoutUserLogged()
    {
        $this->post(
            'api/editable/save', [])
            ->assertRedirectedTo('login');
    }

    /**
     * Test editable save by Model
     *
     * @group failing
     * @return void
     */
    public function testEditableSaveByModel()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user, 'api')
            ->post(
                'api/editable/save',
                $this->generateFormDataForEditableByModelSave())
                 ->seeInDatabase($this->tablename, [$this->fieldname => $this->content]);
//                 ->seeJson();
    }

    /**
     * Test editable save
     *
     * @group ok
     * @return void
     */
    public function testEditableSave()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user, 'api')
            ->post(
            'api/editable/save',
            $this->generateFormDataForEditableSave())->dump();
//                 ->seeInDatabase($this->tablename, [$this->fieldname => $this->content]);
//                 ->seeJson();
    }

    /**
     * Test editable save trying to update not existing field
     *
     * @group ok
     * @return void
     */
    public function testEditableSaveTryToUpdateNotExistingField()
    {
        $this->post(
            'api/editable/save',
            $this->generateFormDataForEditableSave())
            ->seeJson();
    }

    /**
     * Generate form data for Editable save
     *
     * @return array
     */
    protected function generateFormDataForEditableSave()
    {
        $formData = [
            'content' => $this->content,
            'fieldname' => $this->fieldname,
            'tablename' => $this->tablename,
            'tableid' => $this->id,
        ];
        return $formData;
    }

    /**
     *Generate form data for Editable save by Model
     */
    protected function generateFormDataForEditableByModelSave() {
        $formData = [
            'model' => $this->model,
            'content' => $this->content,
            'fieldname' => $this->fieldname,
            'tableid' => $this->id
        ];
        return $formData;
    }

}
