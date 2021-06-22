<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Block\Renderer\Blocks;

class HtmlList extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = "Wamoco_EditorJS::renderer/list.phtml";

    /**
     * getItems
     * @return array
     */
    public function getItems()
    {
        $data = $this->getData('data');
        if (!$data) {
            return null;
        }
        $items = $data['items'];
        return $items;
    }

    /**
     * getTag
     * @return string
     */
    public function getTag()
    {
        $data = $this->getData('data');
        if (array_key_exists('style', $data) && $data['style'] == 'ordered') {
            return "ol";
        }
        return "ul";
    }
}

