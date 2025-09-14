<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\Utility;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * Class UriUtility
 *
 * @author Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class UriUtility
{
    /**
     * Renders the URI to the JSON provider
     * for the auto suggest field.
     *
     * @param string $identifier
     * @param int $pageType
     * @param string $pids
     * @param array $additionalParameters
     * @return string
     */
    public static function createEndpointUri(
        string $identifier,
        int $pageType,
        string $pids = '',
        array $additionalParameters = []
    ): string {
        if (!($GLOBALS['TYPO3_REQUEST'] ?? null) instanceof ServerRequestInterface
            || !ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isBackend()
        ) {
            $parameters['page_id'] = $GLOBALS['TYPO3_REQUEST']->getAttribute('routing')->getPageId();
        }

        $parameters['type'] = $pageType;
        $parameters['tx_suggest'] = $identifier;

        ArrayUtility::mergeRecursiveWithOverrule(
            $parameters,
            $additionalParameters,
            true,
            false
        );

        if (!empty($pids)) {
            $parameters['pids'] = $pids;
        }

        return '/?' . http_build_query($parameters);
    }
}
