<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Block\Renderer\Blocks;

class RawHtml extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = "Wamoco_EditorJS::renderer/raw.phtml";

    /**
     * getRaw
     * @return string
     */
    public function getRaw()
    {
        $data = $this->getData('data');
        if (!$data) {
            return "";
        }
        if (!array_key_exists('html', $data)) {
            return "";
        }
        $raw = $data['html'];
        return $raw;
    }
}
