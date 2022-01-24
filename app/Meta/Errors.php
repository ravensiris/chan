<?php

use OpenApi\Attributes as OAT;

#[OAT\Schema(schema: 'ErrorResponse')]
class ErrorResponse
{
    #[OAT\Property(
        items: new OAT\Items(ref: '#/components/schemas/ErrorCollection')
    )]
    public array $error;
}

#[OAT\Schema(schema: 'ErrorCollection')]
class ErrorCollection
{
    #[OAT\Property(
        type: 'array',
        items: new OAT\Items(ref: '#/components/schemas/Error')
    )]
    public $errors;
    #[OAT\Property(
        type: 'integer',
        example: 400
    )]
    public $code;
    #[OAT\Property(
        type: 'string',
        example: 'Invalid uuid'
    )]
    public $message;
}

#[OAT\Schema(schema: 'Error')]
class InnerError
{

    #[OAT\Property(
        type: 'string',
        example: 'global'
    )]
    public $domain;
    #[OAT\Property(
        type: 'string',
        example: 'notFound'
    )]
    public $reason;
    #[OAT\Property(
        type: 'string',
        example: 'Resource not found'
    )]
    public $message;
    #[OAT\Property(
        type: 'string',
        example: 'url'
    )]
    public $locationType;
    #[OAT\Property(
        type: 'string',
        example: '/boards/{}'
    )]
    public $location;
}
