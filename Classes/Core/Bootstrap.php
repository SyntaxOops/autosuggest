<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\Core;

use SyntaxOOps\Autosuggest\Exception;
use SyntaxOOps\Autosuggest\Service\SuggestServiceInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Bootstrap
 *
 * @author  Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class Bootstrap
{
    /**
     * Generates a JSON of the requested service
     * using the provided identifier
     *
     * @param string $content
     * @param array $configuration
     * @return string
     * @throws Exception
     */
    public function run(string $content, array $configuration): string
    {
        $serviceIdentifier = $this->getServiceIdentifier($configuration);
        $service = $this->getServiceInstance($serviceIdentifier);

        return json_encode($service->generateItems());
    }

    /**
     * Determines the service identifier
     *
     * @param array $configuration
     * @return string
     */
    protected function getServiceIdentifier(array $configuration): string
    {
        if ($serviceIdentifier = $configuration['serviceIdentifier']) {
            return $serviceIdentifier;
        }

        $request = $GLOBALS['TYPO3_REQUEST'];

        if ($request->getQueryParams()['tx_suggest']) {
            return $request->getQueryParams()['tx_suggest'];
        }

        return '';
    }

    /**
     * Returns the singleton of a service identifier
     *
     * @param $serviceIdentifier
     * @return SuggestServiceInterface
     * @throws Exception
     */
    protected function getServiceInstance($serviceIdentifier): SuggestServiceInterface
    {
        $className = $GLOBALS['TYPO3_CONF_VARS']['EXT']['autosuggest'][$serviceIdentifier];

        if (empty($className)) {
            throw new Exception(
                sprintf('No suggest service found for the identifier "%s"', $serviceIdentifier),
                1504017523
            );
        }

        return GeneralUtility::makeInstance($className);
    }
}
