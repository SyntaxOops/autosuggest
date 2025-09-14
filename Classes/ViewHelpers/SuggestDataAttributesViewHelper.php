<?php

declare(strict_types=1);

/*
 * This file is part of the "autosuggest" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace SyntaxOOps\Autosuggest\ViewHelpers;

use SyntaxOOps\Autosuggest\Utility\ExtensionUtility;
use SyntaxOOps\Autosuggest\Utility\SuggestDataAttributesUtility;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Generates an array of additional HTML attributes
 * You may insert that into a TextField form element
 *
 * ```html
 *  <f:form.textfield
 *      name="my_field"
 *      additionalAttributes="{autosuggest:suggestDataAttributes(identifier: 'news',pids: '7',
 *      additionalParameters: {table: 'tx_news_domain_model_news', field: 'title', recursive: 1, recursive_depth: 99})}"
 *  />
 * ```
 *
 * Class SuggestDataAttributesViewHelper
 *
 * @author  Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class SuggestDataAttributesViewHelper extends AbstractViewHelper
{
    /**
     * initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'identifier',
            'string',
            'Auto Suggest service identifier',
            true
        );
        $this->registerArgument(
            'pids',
            'string',
            'Storage pids separated by comma',
            false,
            ''
        );
        $this->registerArgument(
            'additionalParameters',
            'array',
            'Additional parameters that will be used in query url',
            false,
            []
        );
    }

    /**
     * @return array
     */
    public function render(): array
    {
        $settings = ExtensionUtility::getSettings();
        $arguments = $this->arguments;

        $additionalAttributes = SuggestDataAttributesUtility::get(
            $arguments['identifier'],
            $settings['ajaxTypeNum'],
            $arguments['pids'],
            $arguments['additionalParameters']
        );

        if (is_array($settings['additionalAttributes'])) {
            ArrayUtility::mergeRecursiveWithOverrule($additionalAttributes, $settings['additionalAttributes']);
        }

        return $additionalAttributes;
    }
}
