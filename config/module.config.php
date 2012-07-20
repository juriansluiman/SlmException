<?php
return array(
    'error' => array(
        'exceptions' => array(
            'BadRequest'       => 400,
            'Unauthorized'     => 401,
            'Forbidden'        => 403,
            'PageNotFound'     => 404,
            'MethodNotAllowed' => 405,
        ),
    ),

    'view_manager' => array(
        'not_found_template'       => 'error/page-not-found',
        'exception_template'       => 'error/server-error',

        'template_map' => array(
            // 4xx errors
            'error/bad-request'        => __DIR__ . '/../view/error/bad-request.phtml',
            'error/unauthorized'       => __DIR__ . '/../view/error/unauthorized.phtml',
            'error/forbidden'          => __DIR__ . '/../view/error/forbidden.phtml',
            'error/page-not-found'     => __DIR__ . '/../view/error/page-not-found.phtml',
            'error/method-not-allowed' => __DIR__ . '/../view/error/method-not-allowed.phtml',

            // 5xx errrors
            'error/server-error' => __DIR__ . '/../view/error/server-error.phtml',
        ),
    ),
);
