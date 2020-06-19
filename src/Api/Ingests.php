<?php

namespace TwitchApi\Api;

trait Ingests
{
    /**
     * Get ingest server list
     *
     * @return array|string
     */
    public function getIngests()
    {
        return $this->get('ingests');
    }
}
