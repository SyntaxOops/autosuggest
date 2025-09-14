<?php

declare(strict_types=1);

namespace SyntaxOOps\Autosuggest\Xclass\Form\Element;

use SyntaxOOps\Autosuggest\Utility\ExtensionUtility;
use SyntaxOOps\Autosuggest\Utility\SuggestDataAttributesUtility;
use TYPO3\CMS\Backend\Form\Element\InputTextElement as ExtendedInputTextElement;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class TextElement
 *
 * @author Haythem Daoud <haythemdaoud.x@gmail.com>
 */
class InputTextElement extends ExtendedInputTextElement
{
    /**
     * @return array
     * @throws \JsonException
     */
    public function render(): array
    {
        $settings = ExtensionUtility::getSettings();
        $parameterArray = $this->data['parameterArray'];
        $config = $parameterArray['fieldConf']['config'];

        $resultArray = parent::render();

        if (isset($config['autosuggest'])) {
            $autoSuggestConfig = $config['autosuggest'];
            $htmlArray = explode(LF, $resultArray['html']);
            $inputHtml = $htmlArray[5];

            $attributes = SuggestDataAttributesUtility::get(
                $autoSuggestConfig['identifier'],
                $settings['ajaxTypeNum'],
                $autoSuggestConfig['storage_pids'] ?? '',
                $autoSuggestConfig['additionalUriParameters'] ?? []
            );

            if (isset($autoSuggestConfig['additionalParameters'])) {
                ArrayUtility::mergeRecursiveWithOverrule($attributes, $autoSuggestConfig['additionalParameters']);
            }

            // Additional input classes
            $classes = [
                'js-combobox',
                'js-combobox-custom',
            ];

            $modifiedInput = str_replace('/>', GeneralUtility::implodeAttributes($attributes, true) . '/>', $inputHtml);
            $modifiedInput = str_replace('class="', 'class="' . implode(' ', $classes) . ' ', $modifiedInput);

            $htmlArray[5] = $modifiedInput;
            $resultArray['html'] = implode(LF, $htmlArray);

            // Add JS and CSS
            $resultArray['javaScriptModules'][] = JavaScriptModuleInstruction::create(
                '@syntaxoops/autosuggest/autosuggest.js'
            );
            $resultArray['stylesheetFiles'][] = 'EXT:autosuggest/Resources/Public/Css/Backend/autosuggest.css';
        }

        return $resultArray;
    }
}
