<?php


namespace YuriyMartini\Subscriptions\Contracts;


use ArrayAccess;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

interface Model extends Arrayable, ArrayAccess, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    public function getKey();
}
