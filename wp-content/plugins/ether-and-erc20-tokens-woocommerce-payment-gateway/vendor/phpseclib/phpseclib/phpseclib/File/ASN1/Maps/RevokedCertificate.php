<?php

/**
 * RevokedCertificate
 *
 * PHP version 5
 *
 * @category  File
 * @package   ASN1
 * @author    Jim Wigginton <terrafrost@php.net>
 * @copyright 2016 Jim Wigginton
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      http://phpseclib.sourceforge.net
 */
namespace Ethereumico\Epg\Dependencies\phpseclib3\File\ASN1\Maps;

use Ethereumico\Epg\Dependencies\phpseclib3\File\ASN1;
/**
 * RevokedCertificate
 *
 * @package ASN1
 * @author  Jim Wigginton <terrafrost@php.net>
 * @access  public
 */
abstract class RevokedCertificate
{
    const MAP = ['type' => \Ethereumico\Epg\Dependencies\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['userCertificate' => \Ethereumico\Epg\Dependencies\phpseclib3\File\ASN1\Maps\CertificateSerialNumber::MAP, 'revocationDate' => \Ethereumico\Epg\Dependencies\phpseclib3\File\ASN1\Maps\Time::MAP, 'crlEntryExtensions' => ['optional' => \true] + \Ethereumico\Epg\Dependencies\phpseclib3\File\ASN1\Maps\Extensions::MAP]];
}
