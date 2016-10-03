<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditableRefreshPost;
use App\Http\Requests\EditableSavePost;
use App\Repositories\Contracts\EditableRepository;
use DB;

/**
 * Class EditableController
 *
 * @package App\Http\Controllers
 */
class EditableController extends Controller
{

    /**
     * Repository
     *
     * @var EditableRepository
     */
    protected $repo;

    /**
     * EditableController constructor.
     * @param $repo
     */
    public function __construct(EditableRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param EditableSavePost $request
     */
    public function save(EditableSavePost $request)
    {
        $this->repo->save($request->input());
    }

    /**
     * @param EditableSavePost $request
     */
    public function refresh(EditableRefreshPost $request)
    {
        $this->repo->refresh($request->input());
    }



    /*
     * TODO: Repository pattern todo!
     */
    /**
     * @param $input
     */
    protected function saveToDatabase1($input)
    {
        DB::table($input['tablename'])
            ->where($this->getPrimaryKey($input['tablename']), $input['tableid'])
            ->update([$input['fieldname'] => $input['content']]);
    }

    /**
     * @param EditableSavePost $request
     */
    protected function getPrimaryKey($table)
    {
        DB::connection()
            ->getDoctrineSchemaManager()
            ->listTableDetails($table)
            ->getPrimaryKey()->getColumns()[0];
    }
}
