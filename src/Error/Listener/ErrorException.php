<?php

/*
 * This is free and unencumbered software released into the public domain.
 *
 * Anyone is free to copy, modify, publish, use, compile, sell, or
 * distribute this software, either in source code form or as a compiled
 * binary, for any purpose, commercial or non-commercial, and by any
 * means.
 *
 * In jurisdictions that recognize copyright laws, the author or authors
 * of this software dedicate any and all copyright interest in the
 * software to the public domain. We make this dedication for the benefit
 * of the public at large and to the detriment of our heirs and
 * successors. We intend this dedication to be an overt act of
 * relinquishment in perpetuity of all present and future rights to this
 * software under copyright law.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * For more information, please refer to <http://unlicense.org/>
 *
 * @package    Error
 * @copyright  Copyright (c) 2009-2012 Soflomo (http://soflomo.com)
 * @license    http://unlicense.org Unlicense
 */

namespace Error\Listener;

use Zend\Mvc\View\ExceptionStrategy;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Mvc\Application;
use Zend\View\Model\ViewModel;
use Zend\Filter\Word\CamelCaseToDash as CamelCaseToDashFilter;
use Zend\Http\Response as HttpResponse;

use Error\Exception;

/**
 * Description of ErrorException
 */
class ErrorException extends ExceptionStrategy
{
    protected $exceptions;

    public function setExceptionErrors(array $exceptions)
    {
        $this->exceptions = $exceptions;
    }

    public function __invoke(MvcEvent $e)
    {
        // Do nothing if no error in the event
        $error = $e->getError();
        if (empty($error)) {
            return;
        }

        // Do nothing if the result is a response object
        $result = $e->getResult();
        if ($result instanceof Response) {
            return;
        }

        // Do nothing if the error is not triggered during dispatch
        if ($error !== Application::ERROR_EXCEPTION) {
            return;
        }

        // Do nothing when exception is not marked as an Error\Exception\ExceptionInterface
        $exception = $e->getParam('exception');
        if (!is_object($exception) || !$exception instanceof Exception\ExceptionInterface) {
            return;
        }

        // Do nothing when code cannot be found
        $name = $this->checkExceptionCode($exception);
        if (null === $name) {
            return;
        }

        $model = new ViewModel(array(
            'message'            => 'An error occurred during execution; please try again later.',
            'exception'          => $exception,
            'display_exceptions' => $this->displayExceptions(),
        ));

        $template = $this->getTemplatename($name);
        $model->setTemplate($template);
        $e->setResult($model);

        $response = $e->getResponse();
        if (!$response) {
            $response = new HttpResponse();
            $e->setResponse($response);
        }

        $code = $this->exceptions[$name];
        $response->setStatusCode($code);

        // Unset error to stop other exception listeners from triggering
        $e->setError(null);
    }

    /**
     * Check if we recognize the exception and can parse it to a HTTP status code
      *
     * @param  Exception\ExceptionInterface $exception Exception thrown
     * @return string                                  Name of the exception we know
     */
    protected function checkExceptionCode(Exception\ExceptionInterface $exception)
    {
        $interfaces = class_implements($exception);
        foreach($interfaces as $name) {
            /**
             * Strip namespace part and Interface suffix
             *
             * Example: My\Foo\MyNameInterface gives "MyName"
             */
            $name = substr($name, strrpos($name, '\\') + 1);
            $name = substr($name, 0, -1 * strlen('Interface'));

            if (isset($this->exceptions[$name])) {
                // We have a code for this name, so return this name
                return $name;
            }
        }
    }

    /**
     * Get template name based on exception interface name
     *
     * @param  string $exceptionName Name of the Exception interface
     * @return string                Name of the template name
     */
    protected function getTemplatename($exceptionName)
    {
        $filter   = new CamelCaseToDashFilter;
        $name     = $filter->filter($exceptionName);
        $template = 'error/' . strtolower($name);

        return $template;
    }
}