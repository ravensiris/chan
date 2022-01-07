<?php

use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;

/**
 *  Create an error array
 *
 *  @param string $domain error's domain
 *  @param string $reason error's reason
 *  @param string $message error's message
 *  @param RequestDataLocation error's location
 *  @return array
 * */
function make_error(
    string $domain,
    string $reason,
    string $message,
    RequestDataLocation $requestDataLocation
) {
    $error = [
        'domain' => $domain,
        'reason' => $reason,
        'message' => $message,
    ];

    $requestDataLocation->attach($error);

    return $error;
}


/**
 *  Throw a ValidationException with pre-prepared request.
 *
 *  @param Validator $validator failed validator
 *  @throws ValidationException
 * */
function uuid_error(
    Validator $validator,
) {
    $request = app(Request::class);
    $invalid_uuid = $validator->getData()['uuid'];
    $location = RequestDataLocation::from_request($request, 'uuid');
    throw new ValidationException(
        $validator,
        response()->json([
            'error' =>
            [
                'errors' => [
                    make_error(
                        request_domain($request),
                        'invalidUuid',
                        "`$invalid_uuid` is not a valid UUIDv4.",
                        $location
                    )
                ],
                'code' => 400,
                'message' => "`$invalid_uuid` is not a valid UUIDv4."
            ],
        ], 400)
    );
}

/**
 * RequestDataLocation stores location of data inside a Request
 * */
class RequestDataLocation
{
    public ?string $locationType;
    public ?string $location;

    /**
     * Constructor defaulting to null
     *
     * @param ?string $locationType location type e.g. 'path', 'json', 'header'
     * @param ?string $location actual location: url path, json field, header name
     * */
    function __construct(?string $locationType = null, ?string $location = null)
    {
        $this->locationType = $locationType;
        $this->location = $location;
    }

    /**
     * Tries to find your data inside a Request using $data_key
     *
     * @param Request $request request to search in
     * @param string $data_key key to search for
     * */
    public static function from_request(Request $request, string $data_key)
    {
        $locationType = null;
        $location = null;

        // TODO: detect params
        if ($request->json()->has($data_key)) {
            $locationType = 'json';
            $location = $data_key;
        } elseif (array_key_exists($data_key, $request->route()[2] ?? [])) {
            $locationType = 'path';
            $location = request_pattern($request);
            // mark slug
            $location = str_replace("{{$data_key}}", '{}', $location);
        }

        return new self($locationType, $location);
    }

    /**
     * Attach data to an array, skip null values.
     *
     * $array modified by reference.
     *
     * @param array &$array where to put data to
     * */
    public function attach(array &$array)
    {
        if (!is_null($this->locationType)) {
            $array['locationType'] = $this->locationType;
        }
        if (!is_null($this->location)) {
            $array['location'] = $this->location;
        }
    }
}


/**
 *  Find Request's domain
 *
 *  Request must have a controller.
 *  Controller must have a $model static variable.
 *
 *  @param Request $request request to search from
 *  @return string domain
 * */
function request_domain(Request $request)
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

/**
 *  Find Request's url pattern
 *
 *  @param Request $request request to search from
 *  @return ?string url pattern
 * */
function request_pattern(Request $request)
{
    $routes = app('router')->getRoutes();
    $route_method = $request->route()[1]['uses'];

    foreach ($routes as $route) {
        if ($route['action']['uses'] == $route_method) {
            return $route['uri'];
        }
    }
    return null;
}
