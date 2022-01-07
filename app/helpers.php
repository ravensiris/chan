<?php

use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;

// Enum requires PHP 8.1
enum Domain: string
{
    case Global = 'global';
    case Board = 'board';
    case Thread = 'thread';
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
    string $domain,
    string $reason,
    string $message,
    string|null $locatonType,
    string|null $location
) {
    $error = [
        'domain' => $domain,
        'reason' => $reason,
        'message' => $message,
    ];
    if ($locatonType !== null) {

        $error['locationType'] = $locatonType;
    }

    if ($location !== null) {
        $error['location'] = $location;
    }

    return $error;
}

function uuid_error(
    Validator $validator,
    Request $request,
    string $invalid_uuid,
) {

    // TODO: in_json, in_params are untested.

    if (in_path($request, $invalid_uuid)) {
        $location_type = 'path';
        $location = '/' . substr($request->path(), 0, -strlen($invalid_uuid));
    } elseif (in_json($request, $invalid_uuid)) {
        $location_type = 'json';
        $location = array_search($invalid_uuid, $request->json()->all());
    } elseif (in_params($request, $invalid_uuid)) {
        $location_type = 'parameter';
        $location = array_search($invalid_uuid, $request->all());
    } else {
        $location_type = null;
        $location = null;
    }

    throw new ValidationException(
        $validator,
        response()->json([
            'error' =>
            [
                'errors' => [
                    make_error(
                        get_domain($request),
                        'invalidUuid',
                        "`$invalid_uuid` is not a valid UUIDv4.",
                        $location_type,
                        $location
                    )
                ],
                'code' => 400,
                'message' => "`$invalid_uuid` is not a valid UUIDv4."
            ],
        ], 400)
    );
}

function in_path(Request $request, string $value)
{
    return in_array($value, $request->route()[2] ?? []);
}

function in_params(Request $request, string $value)
{
    return in_array($value, $request->all());
}

function in_json(Request $request, string $value)
{
    return in_array($value, $request->json()->all());
}

function get_domain(Request $request)
{
    try {
        $name = $request->route();
        $handler = $name[1]['uses'];
        $class = explode("@", $handler)[0];
        $domain_name = strtolower((new ReflectionClass($class::$model))->getShortName());

        return $domain_name;
    } catch (\Throwable $e) {
        return 'global';
    }
}
