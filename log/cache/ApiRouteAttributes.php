<?php return \Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
    $o = [
        clone (($p = &\Symfony\Component\VarExporter\Internal\Registry::$prototypes)['PHPMaker2024\\sgq\\Attributes\\Map'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('PHPMaker2024\\sgq\\Attributes\\Map')),
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone $p['PHPMaker2024\\sgq\\Attributes\\Map'],
        clone ($p['PHPMaker2024\\sgq\\Attributes\\Get'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('PHPMaker2024\\sgq\\Attributes\\Get')),
        clone $p['PHPMaker2024\\sgq\\Attributes\\Get'],
    ],
    null,
    [
        'PHPMaker2024\\sgq\\Attributes\\Map' => [
            'methods' => [
                [
                    'POST',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'OPTIONS',
                ],
                [
                    'POST',
                    'OPTIONS',
                ],
                [
                    'POST',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'POST',
                    'DELETE',
                    'OPTIONS',
                ],
                [
                    'POST',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'POST',
                    'OPTIONS',
                ],
                [
                    'POST',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'POST',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'POST',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'POST',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'POST',
                    'OPTIONS',
                ],
                [
                    'GET',
                    'POST',
                    'OPTIONS',
                ],
                [
                    'GET',
                ],
                [
                    'GET',
                ],
            ],
            'pattern' => [
                '/login',
                '/list/{table}[/{params:.*}]',
                '/view/{table}[/{params:.*}]',
                '/add/{table}[/{params:.*}]',
                '/edit/{table}[/{params:.*}]',
                '/delete/{table}[/{params:.*}]',
                '/register',
                '/file/{table}/{param}[/{key:.*}]',
                '/export[/{param}[/{table}[/{key:.*}]]]',
                '/upload',
                '/jupload',
                '/session',
                '/lookup[/{params:.*}]',
                '/chart[/{params:.*}]',
                '/permissions/{level}',
                '/push/{action}',
                '/twofa/{action}[/{parm}]',
                '/metadata',
                '/chat/{value:[01]}',
            ],
            'handler' => [
                'PHPMaker2024\\sgq\\ApiController:login',
                'PHPMaker2024\\sgq\\ApiController:list',
                'PHPMaker2024\\sgq\\ApiController:view',
                'PHPMaker2024\\sgq\\ApiController:add',
                'PHPMaker2024\\sgq\\ApiController:edit',
                'PHPMaker2024\\sgq\\ApiController:delete',
                'PHPMaker2024\\sgq\\ApiController:register',
                'PHPMaker2024\\sgq\\ApiController:file',
                'PHPMaker2024\\sgq\\ApiController:export',
                'PHPMaker2024\\sgq\\ApiController:upload',
                'PHPMaker2024\\sgq\\ApiController:jupload',
                'PHPMaker2024\\sgq\\ApiController:session',
                'PHPMaker2024\\sgq\\ApiController:lookup',
                'PHPMaker2024\\sgq\\ApiController:exportchart',
                'PHPMaker2024\\sgq\\ApiController:permissions',
                'PHPMaker2024\\sgq\\ApiController:push',
                'PHPMaker2024\\sgq\\ApiController:twofa',
                'PHPMaker2024\\sgq\\ApiController:metadata',
                'PHPMaker2024\\sgq\\ApiController:chat',
            ],
            'middleware' => [
                [
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                ],
                [
                    'PHPMaker2024\\sgq\\ApiPermissionMiddleware',
                    'PHPMaker2024\\sgq\\JwtMiddleware',
                ],
            ],
            'name' => [
                'login',
                'list',
                'view',
                'add',
                'edit',
                'delete',
                'register',
                'file',
                'export',
                'upload',
                'jupload',
                'session',
                'lookup',
                'chart',
                'permissions',
                'push',
                'twofa',
                'metadata',
                'chat',
            ],
            'options' => [
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
                [],
            ],
        ],
    ],
    [
        $o[0],
        $o[1],
        $o[2],
        $o[3],
        $o[4],
        $o[5],
        $o[6],
        $o[7],
        $o[8],
        $o[9],
        $o[10],
        $o[11],
        $o[12],
        $o[13],
        $o[14],
        $o[15],
        $o[16],
        $o[17],
        $o[18],
    ],
    []
);