<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\Utility;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class SuggestDataAttributesUtility
 *
 * @author Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class SuggestDataAttributesUtility
{
    public const EXTENSION_NAME = 'autosuggest';

    /**
     * Generates a configuration array for
     * the auto suggest field.
     *
     * @param $identifier
     * @param $ajaxTypeNum
     * @param $storagePids
     * @param $additionalParameters
     * @return array
     */
    public static function get(
        $identifier,
        $ajaxTypeNum,
        $storagePids,
        $additionalParameters
    ): array {
        return [
            'list' => md5($identifier),
            'data-combobox-help-text' => LocalizationUtility::translate('combobox.helpText', static::EXTENSION_NAME),
            'data-combobox-button-title' => LocalizationUtility::translate('combobox.buttonTitle', static::EXTENSION_NAME),
            'data-suggestion-single' => LocalizationUtility::translate('suggestion.single', static::EXTENSION_NAME),
            'data-suggestion-plural' => LocalizationUtility::translate('suggestion.plural', static::EXTENSION_NAME),
            'data-json-path' => UriUtility::createEndpointUri(
                (string)$identifier,
                (int)$ajaxTypeNum,
                (string)$storagePids,
                (array)$additionalParameters
            ),
        ];
    }
}
