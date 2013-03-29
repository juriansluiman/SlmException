<?php
/**
 * Copyright (c) 2012-2013 Jurian Sluiman.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package     SlmException
 * @author      Jurian Sluiman <jurian@juriansluiman.nl>
 * @copyright   2012-2013 Jurian Sluiman http://juriansluiman.nl.
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 */

return array(
    'slm_exception' => array(
        'enable_markers'  => false,
        'enable_logging'  => false,
        'enable_messages' => false,

        'default_marker'    => 'SlmException\Exception\ServerErrorInterface',
        'exception_markers' => array(
            // 4xx errors
            'SlmException\Exception\BadRequestInterface'       => 400,
            'SlmException\Exception\UnauthorizedInterface'     => 401,
            'SlmException\Exception\ForbiddenInterface'        => 403,
            'SlmException\Exception\PageNotFoundInterface'     => 404,
            'SlmException\Exception\MethodNotAllowedInterface' => 405,

            // 5xx errrors
            'SlmException\Exception\ServerErrorInterface'      => 500,
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
            'error/server-error'       => __DIR__ . '/../view/error/server-error.phtml',
        ),
    ),
);
