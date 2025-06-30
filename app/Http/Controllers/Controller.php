<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\OpenApi(
    info: new OA\Info(
        version: '1.0',
        title: 'Bank'
    ),
    servers: [
        new OA\Server(
            url: '{schema}://{host}/api',
            variables: [
                new OA\ServerVariable(
                    serverVariable: 'schema',
                    default: 'http',
                    enum: ['http']
                ),
                new OA\ServerVariable(
                    serverVariable: 'host',
                    default: 'localhost',
                    enum: ['localhost']
                ),
            ]
        ),
    ],
    components: new OA\Components(
        headers: [
            new OA\Header(header: 'X-User-ID', required: true, schema: new OA\Schema(type: 'string')),
        ],
        securitySchemes: [
            new OA\SecurityScheme(
                securityScheme: 'bearerAuth',
                type: 'http',
                bearerFormat: 'JWT',
                scheme: 'bearer'
            ),
        ]
    )
)]
abstract class Controller
{
    //
}
