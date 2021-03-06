<?php


namespace PN\Resources\Repositories;


use PN\Foundation\Repositories\BaseRepository;
use PN\Resources\Resource;

class ResourceRepository extends BaseRepository implements ResourceRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Resource::class;
    }

    /**
     * Adds the entity to this repository
     *
     * @param $entity
     * @return mixed
     */
    public function add($entity)
    {
        $entity->save();

        \Cache::put('resources.'.$entity->id, $entity, 3600);
    }

    /**
     * Updates the entity to this repository
     *
     * @param $entity
     * @return mixed
     */
    public function edit($entity)
    {
        $entity->save();

        \Cache::put('resources.'.$entity->id, $entity, 3600);
    }

    /**
     * Removes the entity from this repository
     *
     * @param $entity
     * @return mixed
     */
    public function remove($entity)
    {
        $entity->delete();

        \Cache::forget('resources.'.$entity->id);
    }

    /**
     * Finds the last created resource mod by username and repo
     *
     * @param $username
     * @param $repo
     * @return mixed
     */
    public function findMod($username, $repo)
    {
        return Resource::where('source', sprintf('https://github.com/%s/%s', $username, $repo))
            ->orderBy('id', 'desc')
            ->first();
    }
}