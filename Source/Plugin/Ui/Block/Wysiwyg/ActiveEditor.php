<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Plugin\Ui\Block\Wysiwyg;

class ActiveEditor
{
    /**
     * afterGetWysiwygAdapterPath
     *
     * @param mixed $subject
     * @param mixed $path
     * @return string
     */
    public function afterGetWysiwygAdapterPath($subject, $path)
    {
        return "Wamoco_EditorJS/js/editorAdapter";
    }
}
