<?php
/**
 * @package    Zenomania\CoreBundle\Service\Upload
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service\Upload;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenomania\CoreBundle\Service\Exception\UploadFileException;

class UploadFile implements UploadInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * Path to upload photo
     *
     * @var string
     */
    protected $uploadPath;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Корневой путь к директории для загрузки
     * @return string
     */
    public function getUploadRootPath()
    {
        return $this->getParameter('upload_dir');
    }

    /**
     * Upload files
     *
     * @param UploadedFile $file
     * @param array $options
     * @return array list of uploaded files
     * @throws UploadFileException
     */
    public function upload(UploadedFile $file, $options = array())
    {
        if (empty($options['name'])) {
            // Generate a unique name for the file before saving it
            $fileNamePrefix = md5(uniqid());
        } else {
            $fileNamePrefix = $options['name'];
        }
        $fileName = $fileNamePrefix . '.' . $file->guessExtension();
        // Move the file to the directory where files are stored
        $uploadPath = $this->getUploadPath();
        //$directory = $this->getParameter('kernel.root_dir'). sprintf('/../web/%s/', trim($uploadPath, '/'));
        $directory = $this->getUploadRootPath() . sprintf('/%s/', trim($uploadPath, '/'));
        $file->move($directory, $fileName);

        // path relative to kernel.root_dir
        $path = $uploadPath . $fileName;

        return [
            'path' => $path,
            'full_path' => $directory . $fileName
        ];
    }

    /**
     * @param $param
     * @return mixed
     */
    protected function getParameter($param)
    {
        return $this->getContainer()->getParameter($param);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return string
     * @throws UploadFileException
     */
    public function getUploadPath()
    {
        if (null === $this->uploadPath) {
            throw new UploadFileException("Photo upload path is not set");
        }
        return $this->uploadPath;
    }

    /**
     * @param string $uploadPath
     */
    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }
}