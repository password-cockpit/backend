<?php

/**
 * Description of PermissionValidationMiddleware
 *
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Giona Guidotti <giona.guidotti@blackpoints.ch>
 */

namespace User\Api\V1\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Service\ProblemDetailsException;
use Laminas\InputFilter\Factory;
use Laminas\InputFilter\InputFilter;
use Laminas\Db\Adapter\Adapter;

class PermissionValidationMiddleware implements MiddlewareInterface
{
    /**
     *
     * @var Factory
     */
    private $inputFilterFactory;

    /**
     *
     * @var Adapter
     */
    private $adapter;

    /**
     *
     * @var array
     */
    private $languages;

    /**
     *
     * @var type
     */
    private $translator;

    /**
     * Constructor
     *
     * @param Adapter $adapter
     * @param array $languages
     * @param Translator $translator
     */
    public function __construct(Adapter $adapter, $languages, $translator)
    {
        $this->inputFilterFactory = new Factory();
        $this->adapter = $adapter;
        $this->languages = $languages;
        $this->translator = $translator;
    }

    /**
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $payload = $request->getParsedBody();

        $exclude = null;
        if ($request->getAttribute('id')) {
            $userId = $request->getAttribute('id');
            $exclude = [
                'field' => 'user_id',
                'value' => $userId
            ];
        }

        $inputFilterSpecification = [
            [
                'name' => 'access_all_folders',
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    [
                        'name' => \Laminas\Filter\Boolean::class,
                        'options' => [
                            'casting' => false,
                            'type' => [
                                \Laminas\Filter\Boolean::TYPE_NULL,
                                \Laminas\Filter\Boolean::TYPE_BOOLEAN,
                                \Laminas\Filter\Boolean::TYPE_INTEGER
                            ]
                        ]
                    ]
                ],
                'validators' => [
                    [
                        'name' => \Laminas\Validator\Callback::class,
                        'options' => [
                            'callback' => function ($value) {
                                return is_bool($value);
                            }
                        ]
                    ]
                ]
            ],
            [
                'name' => 'manage_users',
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    [
                        'name' => \Laminas\Filter\Boolean::class,
                        'options' => [
                            'casting' => false,
                            'type' => [
                                \Laminas\Filter\Boolean::TYPE_NULL,
                                \Laminas\Filter\Boolean::TYPE_BOOLEAN,
                                \Laminas\Filter\Boolean::TYPE_INTEGER
                            ]
                        ]
                    ]
                ],
                'validators' => [
                    [
                        'name' => \Laminas\Validator\Callback::class,
                        'options' => [
                            'callback' => function ($value) {
                                return is_bool($value);
                            }
                        ]
                    ]
                ]
            ],
            [
                'name' => 'create_folders',
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    [
                        'name' => \Laminas\Filter\Boolean::class,
                        'options' => [
                            'casting' => false,
                            'type' => [
                                \Laminas\Filter\Boolean::TYPE_NULL,
                                \Laminas\Filter\Boolean::TYPE_BOOLEAN,
                                \Laminas\Filter\Boolean::TYPE_INTEGER
                            ]
                        ]
                    ]
                ],
                'validators' => [
                    [
                        'name' => \Laminas\Validator\Callback::class,
                        'options' => [
                            'callback' => function ($value) {
                                return is_bool($value);
                            }
                        ]
                    ]
                ]
            ],
            [
                'name' => 'view_logs',
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    [
                        'name' => \Laminas\Filter\Boolean::class,
                        'options' => [
                            'casting' => false,
                            'type' => [
                                \Laminas\Filter\Boolean::TYPE_NULL,
                                \Laminas\Filter\Boolean::TYPE_BOOLEAN,
                                \Laminas\Filter\Boolean::TYPE_INTEGER
                            ]
                        ]
                    ]
                ],
                'validators' => [
                    [
                        'name' => \Laminas\Validator\Callback::class,
                        'options' => [
                            'callback' => function ($value) {
                                return is_bool($value);
                            }
                        ]
                    ]
                ]
            ]
        ];

        $inputFilter = $this->inputFilterFactory->createInputFilter(
            $inputFilterSpecification
        );
        $inputFilter->setData($payload);
        if (!$inputFilter->isValid()) {
            $errors['errors'] = $this->generateInputErrorMessages($inputFilter);
        }
        if (!empty($errors)) {
            throw new ProblemDetailsException(
                400,
                $this->translator->translate('Validation error'),
                'Bad Request',
                'https://httpstatuses.com/400',
                $errors
            );
        }

        $filteredParams = $inputFilter->getValues(); // only filtered values
        $newPayload = array_merge($payload, $filteredParams); // merge of original payload with filteredParams
        $request = $request->withParsedBody($newPayload);

        return $handler->handle($request);
    }
}
