<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Model\Config\EditorJS;

use Magento\Backend\Model\UrlInterface;

class Config implements \Magento\Framework\Data\Wysiwyg\ConfigProviderInterface
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * __construct
     *
     * @param UrlInterface $urlBuilder
     */
    public function __construct(UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(\Magento\Framework\DataObject $config) : \Magento\Framework\DataObject
    {
        $config->addData([
            'image_upload_url' => $this->urlBuilder->getUrl("wamoco_editorjs/images/upload", []),
            'add_variables'    => false
        ]);

        $this->appendPluginButtonConfig($config);

        return $config;
    }

    /**
     * appendPluginButtonConfig
     *
     * @param mixed $config
     */
    public function appendPluginButtonConfig($config)
    {
        $onclickParts = [
            'search' => ['html_id'],
            'subject' => "EditorJSPlugin.insertBlock({{html_id}});",
        ];

        $variableWysiwyg = [
            [
                'name' => 'editorblock',
                'src' => '#',
                'options' => [
                    'title' => __('Insert Block...'),
                    'url' => '',
                    'onclick' => $onclickParts,
                    'class' => 'action-add-block plugin',
                    'placeholders' => ''
                ],
            ],
        ];
        $configPlugins = (array) $config->getData('plugins');
        $plugins = array_merge($configPlugins, $variableWysiwyg);
        $config->setPlugins($plugins);
    }
}
