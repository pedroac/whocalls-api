<?php

namespace pedroac\whocalls\View;

/**
 * A view for phone numbers lookups.
 */
interface Lookup
{
    /**
     * Show a phone number lookup representation.
     *
     * @param \pedroac\whocalls\Model\Lookup $model
     * @return void
     */
    public function show(\pedroac\whocalls\Model\Lookup $model);
}