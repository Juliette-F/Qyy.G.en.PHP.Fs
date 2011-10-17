<?php
/**
 * @author G. Qyy <pub-gh@qyy.fr>
 * @copyright Copyright (c) 2011,  G. Qyy
 * @license http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 *
 * This software is a PHP set of classes whose purpose is to handle files
 * with Oriented Object paradigm. This software has only an educational aim
 * and is not to be used in a production environment.
 *
 * This software is governed by the CeCILL-B license under French law and
 * abiding by the rules of distribution of free software. You can use,
 * modify and/ or redistribute the software under the terms of the CeCILL-B
 * license as circulated by CEA, CNRS and INRIA at the following URL
 * "http://www.cecill.info".
 *
 * As a counterpart to the access to the source code and rights to copy,
 * modify and redistribute granted by the license, users are provided only
 * with a limited warranty and the software's author, the holder of the
 * economic rights, and the successive licensors have only limited liability.
 *
 * In this respect, the user's attention is drawn to the risks associated
 * with loading, using, modifying and/or developing or reproducing the
 * software by the user in light of its specific status of free software,
 * that may mean that it is complicated to manipulate, and that also
 * therefore means that it is reserved for developers and experienced
 * professionals having in-depth computer knowledge. Users are therefore
 * encouraged to load and test the software's suitability as regards their
 * requirements in conditions enabling the security of their systems and/or
 * data to be ensured and, more generally, to use and operate it in the same
 * conditions as regards security.
 *
 * The fact that you are presently reading this means that you have had
 * knowledge of the CeCILL-B license and that you accept its terms.
 */

// TODO: doc
class Qyy_G_en_File extends Qyy_G_en_FileSystemNode
{
  
  // TODO: doc
  // http://php.net/manual/en/function.file-put-contents.php
  function __construct ($name)
  {  
    Qyy_G_en_FileSystem::ThrowExceptionIfNotFile($name);
    
    parent::__construct($name);
  }

  // TODO: doc
  // http://php.net/manual/en/function.pathinfo.php
  public function GetBasenameNoSuffix ()
  {
    $return = pathinfo($this->GetName(), PATHINFO_FILENAME);
    
    if (is_null($return) || empty($return))
    {
      throw new LengthException('This file seems to start with a dot.', 404);
    }
    
    return $return;
  }
  
  // TODO: doc
  // http://php.net/manual/en/function.pathinfo.php
  public function GetSuffix ()
  {
    $return = pathinfo($this->GetName(), PATHINFO_EXTENSION);
    
    if (is_null($return) || empty($return))
    {
      throw new LengthException('There is no suffix for this file.', 404);
    }
    
    return $return;
  }

  // TODO: doc
  // http://php.net/manual/en/function.file-get-contents.php
  public function GetContents (
    $use_include_path = false,
    $context = null,
    $offset = -1,
    $maxlen = null)
  {
    if (is_null($maxlen))
    {
      $return =
        file_get_contents(
          $this->GetName(),
          $use_include_path,
          $context,
          $offset);
    }
    else
    {
      $return =
        file_get_contents(
          $this->GetName(),
          $use_include_path,
          $context,
          $offset,
          $maxlen);
    }

    if ($return === false)
    {
      $lastError = error_get_last();

      throw new Exception(
        'Unable to retrieve the content of the file. See last php error or '
          .'previous exception of this one for more informations.',
        500,
        new Exception(
          'message: "'.$lastError['message'].'"'.PHP_EOL
            .'file: "'.$lastError['file'].'"'.PHP_EOL
            .'line: `'.$lastError['line'].'`'.PHP_EOL,
          $derniereErreur['type']));
    }

    return $return;
  }
}