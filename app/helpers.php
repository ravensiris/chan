<?php

function make_error($domain, $reason, $message, $locatonType, $location)
{
    return [
        'domain' => $domain,
        'reason' => $reason,
        'message' => $message,
        'locationType' => $locatonType,
        'location' => $location
    ];
}
