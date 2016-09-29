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
     * Test editable save
     *
     * @group failing
     * @return void
     */
    public function testEditableSave()
    {
        $this->post(
            'api/editable/save',
            $this->generateFormDataForEditableSave())
                ->seeJson();
    }

    /**
     * Test editable save trying to update not existing field
     *
     * @group failing
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
     * @return array
     */
    protected function generateFormDataForEditableSave()
    {
        $formData = [
            'content' => 'Begonya Sole Aragones',
            'fieldname' => 'name',
            'tablename' => 'users',
            'tableid' => '1',
        ];
        return $formData;
    }

}
