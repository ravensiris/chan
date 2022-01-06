<?php

use \Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;

// Enum requires PHP 8.1
enum Domain: string
{
    case Global = 'global';
    case Board = 'board';
}

enum Reason: string
{
    case NotFound = 'notFound';
    case InvalidUuid = 'invalidUuid';
}

enum LocationType: string
{
    case Path = 'path';
    case Parameter = 'param';
}

function make_error(
    Domain $domain,
    Reason $reason,
    string $message,
    LocationType $locatonType,
    string $location
) {
    return [
        'domain' => $domain->value,
        'reason' => $reason->value,
        'message' => $message,
        'locationType' => $locatonType->value,
        'location' => $location
    ];
}

function uuid_error(
    Validator $validator,
    string $invalid_uuid,
    string $location,
    Domain $domain = Domain::Global,
    LocationType $locationType = LocationType::Path,
) {
    throw new ValidationException(
        $validator,
        response()->json([
            'error' =>
            [
                'errors' => [
                    make_error(
                        $domain,
                        Reason::InvalidUuid,
                        "`$invalid_uuid` is not a valid UUIDv4.",
                        $locationType,
                        $location
                    )
                ],
                'code' => 400,
                'message' => "`$invalid_uuid` is not a valid UUIDv4."
            ],
        ], 400)
    );
}
