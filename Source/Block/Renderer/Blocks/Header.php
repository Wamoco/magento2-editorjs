<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Block\Renderer\Blocks;

class Header extends \Magento\Framework\View\Element\Template
{
    protected $_template = "Wamoco_EditorJS::renderer/header.phtml";

    public function getLevel()
    {
        $data = $this->getData('data');
        if (!$data) {
            return "";
        }
        $level = $data['level'];
        return $level;
    }

    public function getText()
    {
        $data = $this->getData('data');
        if (!$data) {
            return "";
        }
        $text = $data['text'];
        return $text;
    }

    public function getTag()
    {
        return "h" . $this->getLevel();
    }
}
