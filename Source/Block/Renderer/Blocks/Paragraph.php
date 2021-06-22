<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Block\Renderer\Blocks;

class Paragraph extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = "Wamoco_EditorJS::renderer/paragraph.phtml";

    /**
     * getText
     * @return string
     */
    public function getText()
    {
        $data = $this->getData('data');
        if (!$data) {
            return "";
        }
        $text = $data['text'];
        return $text;
    }
}
