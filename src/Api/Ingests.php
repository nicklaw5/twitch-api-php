<?php

namespace TwitchApi\Api;

trait Ingests
{
    /**
     * Get ingest server list
     *
     * @return array|json
     */
    public function getIngests()
    {
        return $this->get('ingests');
    }
}
