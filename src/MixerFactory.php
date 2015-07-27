<?php

/**
 * This file is part of the GuzzleStereo package
*
* (c) Christophe Willemsen <willemsen.christophe@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
*/

namespace Ikwattro\GuzzleStereo;

class MixerFactory
{
    protected $mixer;

    public function __construct(array $filters = array(), array $blacklists = array())
    {
        $this->mixer = new Mixer();
    }

    public function getMixer()
    {
        return $this->mixer;
    }
}
