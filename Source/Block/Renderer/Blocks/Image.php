<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Block\Renderer\Blocks;

class Image extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = "Wamoco_EditorJS::renderer/image.phtml";

    /**
     * getImageUrl
     * @return string
     */
    public function getImageUrl()
    {
        $data = $this->getData('data');
        if (!$data) {
            return null;
        }
        $file = $data['file'];
        if (!$file) {
            return null;
        }
        $url = $file['url'];
        return $url;
    }

    /**
     * isStretched
     * @return bool
     */
    public function isStretched()
    {
        $data = $this->getData('data');
        if (is_array($data) && array_key_exists('stretched', $data) && $data['stretched'] == 1) {
            return true;
        }
        return false;
    }

    /**
     * hasLink
     * @return bool
     */
    public function hasLink()
    {
        return $this->getLink() != false;
    }

    /**
     * getLink
     * @return string
     */
    public function getLink()
    {
        $data = $this->getData('data');
        if (is_array($data) && array_key_exists('link', $data)) {
            return $data['link'];
        }
        return false;
    }
}
