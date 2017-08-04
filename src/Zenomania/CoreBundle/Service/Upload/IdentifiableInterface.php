<?php
/**
 * @package    Zenomania\CoreBundle\Service\Upload
 * @author     miholeus <me@miholeus.com> {@link http://miholeus.com}
 * @version    $Id: $
 */

namespace Zenomania\CoreBundle\Service\Upload;

/**
 * Identifiable objects that have their own upload paths
 */
interface IdentifiableInterface
{
    public function getId();
}