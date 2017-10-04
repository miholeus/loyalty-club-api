<?php
/**
 * Created by PhpStorm.
 * @author  Gizmo <gizmolife@gmail.com> {@link https://vk.com/id3558208}
 * Date: 27.09.2017
 * Time: 13:36
 */

namespace Zenomania\CoreBundle\Form\Model;


class FileUpload
{
    const FIELD_CODE = 'CODE';
    const FIELD_ACTION = 'ACTION';
    const FIELD_COUNT_ZEN = 'COUNT_ZEN';

    private $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
}