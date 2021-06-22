<?php
/**
 * Greetings from Wamoco GmbH, Bremen, Germany.
 * @author Wamoco Team<info@wamoco.de>
 * @license See LICENSE.txt for license details.
 */

namespace Wamoco\EditorJS\Controller\Adminhtml\Images;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGet;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPost;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;

class Upload extends \Magento\Backend\App\Action implements HttpGet, HttpPost, CsrfAwareActionInterface
{
    const MEDIA_FOLDER = 'wysiwyg';
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var mixed
     */
    protected $mediaDirectory;

    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $fileUploaderFactory;

    /**
     * __construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        parent::__construct($context);
        $this->storeManager         = $storeManager;
        $this->jsonFactory          = $jsonFactory;
        $this->mediaDirectory       = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->fileUploaderFactory  = $fileUploaderFactory;
    }

    /**
     * execute
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();

        try {
            $target = $this->mediaDirectory->getAbsolutePath(self::MEDIA_FOLDER . '/');
            /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
            $uploader = $this->fileUploaderFactory->create(['fileId' => 'image']);
            /** Allowed extension types */
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'zip', 'doc']);
            /** rename file name if already exists */
            $uploader->setAllowRenameFiles(true);
            /** upload file in folder "mycustomfolder" */
            $result = $uploader->save($target);
            if ($result['file']) {
                $this->messageManager->addSuccess(__('File has been successfully uploaded'));
            }
        } catch (\Exception $e) {
            return $resultJson->setData([
                'success' => 0,
                'message' => $e->getMessage()
            ]);
        }

        return $resultJson->setData([
            'success' => 1,
            'file' => [
                'url' => $this->getMediaUrl($result['file'])
            ]
        ]);
    }

    public function getMediaUrl($file)
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .
            self::MEDIA_FOLDER . '/' .
            $file;
    }

    protected function _validateSecretKey()
    {
        return true;
    }

    public function createCsrfValidationException(RequestInterface $request) : ?InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(RequestInterface $request) : ?bool
    {
        return true;
    }

    public function _processUrlKeys()
    {
        if ($this->_auth->isLoggedIn()) {
            return true;
        }
        return false;
    }
}
