<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HasManyThroughSelf extends Relation
{

    /** @var Illuminate\Database\Eloquent\Builder */
    protected $query;

    /** @var Illuminate\Database\Eloquent\Model */
    protected $model;

    /** @var Illuminate\Database\Eloquent\Model */
    protected $parent;

    public function __construct(
        Model $parent,
        Model $model,
        $foreignId=null,
        $table=null,
        $localId='id',
        $parentId=null,
    )
    {
        $this->parent = $parent;
        $this->model = $model;
        $this->query = $model->newQuery();
        $this->table = $table ?? $this->model->getTable();
        $this->localId = $localId ?? 'id';
        $this->foreignId = $foreignId ?? Str::snake($table . ' ' . 'id');
        $this->parentId = $parentId ?? Str::snake($parent->getTable() . ' ' . 'id');
        $this->localParentId = $parentId ?? 'id';

        parent::__construct($this->query, $this->parent);
    }

    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints()
    {
        $this->query
            ->select('foreign.*')
            ->from("{$this->table} as local")
            ->join("{$this->table} as foreign", "local.{$this->foreignId}", '=', "foreign.{$this->localId}")
            ;

    }

    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param array $models
     *
     * @return void
     */
    public function addEagerConstraints(array $models)
    {
        $this->query->whereIn("local.{$this->parentId}",
            collect($models)->pluck($this->localParentId));
    }

     /**
     * Initialize the relation on a set of models.
     *
     * @param array $models
     * @param string $relation
     *
     * @return array
     */
    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation(
                $relation,
                $this->related->newCollection()
            );
        }

        return $models;
    }

    /**
     * Get the results of the relationship.
     *
     * @return mixed
     */
    public function getResults()
    {
        return $this->query
            ->where("local.{$this->parentId}", $this->parent->{$this->localParentId})
            ->get();
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param array $models
     * @param \Illuminate\Database\Eloquent\Collection $results
     * @param string $relation
     *
     * @return array
     */
    public function match(array $models, Collection $results, $relation)
    {
        if ($results->isEmpty()) {
            return $models;
        }

        foreach ($models as $model) {
            $model->setRelation(
                $relation,
                $results
            );
        }

        return $models;
    }
}
