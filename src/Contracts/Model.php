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
     * @return string
     */
    public function getTable();

    /**
     * @return string
     */
    public function getKeyName();

    /**
     * @return mixed
     */
    public function getKey();

    /**
     * @return string
     */
    public function getForeignKey();
}
