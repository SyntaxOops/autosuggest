<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Class ExtensionUtility
 *
 * @author Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class ExtensionUtility
{
    /**
     * Get extension settings from EXT:autosuggest
     *
     * @return array
     */
    public static function getSettings(): array
    {
        /** @var ConfigurationManager $configurationManager */
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);

        $typoScriptSettings = $configurationManager
                ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

        return GeneralUtility::removeDotsFromTS(
            $typoScriptSettings['plugin.']['tx_autosuggest.']['settings.'] ?? []
        );
    }
}
