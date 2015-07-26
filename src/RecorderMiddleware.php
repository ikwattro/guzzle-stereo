<?php

/*
 * This file is part of the GuzzleStereo package.
 *
 * (c) Christophe Willemsen <willlemsen.christophe@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ikwattro\GuzzleStereo;

use GuzzleHttp\Exception\RequestException;
use Ikwattro\GuzzleStereo\Recorder;

class RecorderMiddleware
{
    /**
     * @param \Ikwattro\GuzzleStereo\Recorder
     * @return callable
     */
    public static function record(Recorder $recorder)
    {
        return function (callable $handler) use ($recorder) {
            return function ($request, array $options) use ($handler, $recorder) {
                return $handler($request, $options)->then(
                  function ($response) use ($request, $recorder) {
                      $recorder->record($response);
                      return $response;
                  },
                  function ($reason) use ($request, $recorder) {
                      $response = $reason instanceof RequestException
                        ? $reason->getResponse()
                        : null;
                      if ($response) {
                          $recorder->record($response);
                      }
                      return \GuzzleHttp\Promise\rejection_for($reason);
                  }
                );
            };
        };
    }
}