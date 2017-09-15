<?php
/**
 * @package    Zenomania\CoreBundle\Service\Upload
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zenomania\CoreBundle\Service\Exception\UploadFileException;
use Zenomania\CoreBundle\Service\Upload\FilePathStrategyInterface;


class UploadProfilePhoto extends UploadPhoto
{
    /**
     * Root upload directory
     *
     * @return mixed
     */
    public function getUploadDirectory()
    {
        return $this->getContainer()->getParameter('profile_upload_photo_dir');
    }

//    /**
//     * @var UploadFile
//     */
//    private $uploadService;
//
//    public function __construct(UploadFile $uploadService)
//    {
//        $this->uploadService = $uploadService;
//    }
//
//    /**
//     * @return \Symfony\Component\DependencyInjection\ContainerInterface
//     */
//    protected function getContainer()
//    {
//        return $this->getUploadService()->getContainer();
//    }
//
//    /**
//     * Upload user profile images
//     *
//     * @param UploadedFile $file
//     * @param array $options
//     * @return array
//     * @throws UploadFileException
//     */
//    public function upload(UploadedFile $file, $options = array())
//    {
//        $relativeDirectory = '';
//        if (isset($options['path'])) {
//            $this->getUploadService()->setUploadPath($options['path']);
//            $relativeDirectory = $options['path'];
//            unset($options['path']);
//        }
//        $uploaded = $this->getUploadService()->upload($file, $options);
//        $relativeFilepath = $uploaded['path'];
//
//        $liip = $this->getContainer()->get('liip_imagine.binary.loader.upload_files');
//        $fileBinary = $liip->find($relativeFilepath);
//        $filter = $this->getContainer()->get('liip_imagine.filter.manager');
//        $filterConfiguration = $filter->getFilterConfiguration()->get('user_thumb');
//        $sizes = $filterConfiguration['filters']['thumbnail']['size'];
//        $sizeString = sprintf("%sx%s", $sizes[0], $sizes[1]);
//
//        $fileNamePrefix = pathinfo($fileBinary->getPath(), PATHINFO_FILENAME);
//
//        $directory = dirname($fileBinary->getPath());
//        // make thumbnail
//        $cache = $filter->applyFilter($fileBinary, 'user_thumb');
//        $fs = new Filesystem();
//        $smallFileName = $fileNamePrefix . '_' . $sizeString . '.' . $cache->getFormat();
//        $smallFile = $directory . $smallFileName;
//        $smallFileRelative = $relativeDirectory . $smallFileName;
//        try {
//            $fs->dumpFile($smallFile, $cache->getContent());
//        } catch (IOException $e) {
//            throw new UploadFileException($e->getMessage());
//        }
//
//        $thumbnail =             [
//            'path' => $smallFileRelative,
//            'full_path' => $smallFile
//        ];
//        return [
//            $uploaded,
//            $thumbnail
//        ];
//    }
//
//    /**
//     * @return UploadFile
//     */
//    public function getUploadService()
//    {
//        return $this->uploadService;
//    }
}