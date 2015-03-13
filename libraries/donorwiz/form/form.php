<?php
/**
 * @package     Joomla.Platform
 * @subpackage  User
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

jimport('joomla.application.component.helper');

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';

class DonorwizForm {
	
	public function cleanPostParameters( $post, $trusted_vars )
	{
		$_post = $post;
		
		foreach ($_post as $key => $value) {
			if( !in_array( $key , $trusted_vars ) )
				unset( $_post[$key] );
			else
				$_post[$key] = strip_tags( $_post[$key] );
				
			if($key == 'message')
				$_post[$key] = mb_substr($_post[$key], 0, 400, 'UTF-8');
		}
		
		return $_post;
	
	}
	
	public function test(){
	
		return 'dfdfd';
	
	}
	
	    public function imageUpload() {
        
        $my        = CFactory::getUser();
        $config    = CFactory::getConfig();
        $mainframe = JFactory::getApplication();
        $jinput    = $mainframe->input;

        // If user is using a flash browser, their session might get reset when mod_security is around
        if ($my->id == 0) {
            $tokenId = $jinput->request->get('token', '', 'NONE');
            $userId  = $jinput->request->get('uploaderid', '', 'NONE');
            $my      = CFactory::getUserFromTokenId($tokenId, $userId);
            $session = JFactory::getSession();
            $session->set('user', $my);
        }

        if (CLimitsLibrary::exceedDaily('photos', $my->id)) {
            $this->_showUploadError(true, JText::_('COM_COMMUNITY_PHOTOS_LIMIT_PERDAY_REACHED'));
            return;
        }

        // We can't use blockUnregister here because practically, the CFactory::getUser() will return 0
        if ($my->id == 0) {
            return;
        }

        // Load up required models and properties
        $photos = JRequest::get('Files');
        $albumId = $jinput->request->get('albumid', '', 'INT');
        $album = $this->_getRequestUserAlbum($albumId);

        // Uploaded images count in this batch
        $batchCount = $jinput->request->get('batchcount', '', 'INT');

        $handler = $this->_getHandler($album);

        /* Do process for all photos */
        foreach ($photos as $imageFile) {
            /* Validating */

            $result = $this->_checkUploadedFile($imageFile, $album, $handler);

            if (!$result['photoTable']) {
                continue;
            }

            //assign the result of the array and assigned to the right variable
            $photoTable = $result['photoTable'];
            $storage = $result['storage'];
            $albumPath = $result['albumPath'];
            $hashFilename = $result['hashFilename'];
            $thumbPath = $result['thumbPath'];
            $originalPath = $result['originalPath'];
            $imgType = $result['imgType'];
            $isDefaultPhoto = $result['isDefaultPhoto'];

            // Remove the filename extension from the caption
            if (JString::strlen($photoTable->caption) > 4) {
                $photoTable->caption = JString::substr($photoTable->caption, 0, JString::strlen($photoTable->caption) - 4);
            }

            // @todo: configurable options?
            // Permission should follow album permission
            $photoTable->published = '1';
            $photoTable->permissions = $album->permissions;

            // Set the relative path.
            // @todo: configurable path?
            $storedPath = $handler->getStoredPath($storage, $album->id);
            $storedPath = $storedPath . '/' . $albumPath . $hashFilename . CImageHelper::getExtension($imageFile['type']);

            $photoTable->image = CString::str_ireplace(JPATH_ROOT . '/', '', $storedPath);
            $photoTable->thumbnail = CString::str_ireplace(JPATH_ROOT . '/', '', $thumbPath);

            //In joomla 1.6, CString::str_ireplace is not replacing the path properly. Need to do a check here
            if ($photoTable->image == $storedPath)
                $photoTable->image = str_ireplace(JPATH_ROOT . '/', '', $storedPath);
            if ($photoTable->thumbnail == $thumbPath)
                $photoTable->thumbnail = str_ireplace(JPATH_ROOT . '/', '', $thumbPath);

            //photo filesize, use sprintf to prevent return of unexpected results for large file.
            $photoTable->filesize = sprintf("%u", filesize($originalPath));

            // @rule: Set the proper ordering for the next photo upload.
            $photoTable->setOrdering();

            // Store the object
            $photoTable->store();

            // We need to see if we need to rotate this image, from EXIF orientation data
            // Only for jpeg image.
            if ($config->get('photos_auto_rotate') && $imgType == 'image/jpeg') {
                $this->_rotatePhoto($imageFile, $photoTable, $storedPath, $thumbPath);
            }

            // Trigger for onPhotoCreate
            $apps = CAppPlugins::getInstance();
            $apps->loadApplications();
            $params = array();
            $params[] = $photoTable;
            $apps->triggerEvent('onPhotoCreate', $params);

            // Set image as default if necessary
            // Load photo album table
            if ($isDefaultPhoto) {
                // Set the photo id
                $album->photoid = $photoTable->id;
                $album->store();
            }

            // @rule: Set first photo as default album cover if enabled
            if (!$isDefaultPhoto && $config->get('autoalbumcover')) {
                $photosModel = CFactory::getModel('Photos');
                $totalPhotos = $photosModel->getTotalPhotos($album->id);

                if ($totalPhotos <= 1) {
                    $album->photoid = $photoTable->id;
                    $album->store();
                }
            }

            // Set the upload count per session
            $session = JFactory::getSession();
            $uploadSessionCount = $session->get('album-' . $album->id . '-upload', 0);

            $uploadSessionCount++;
            $session->set('album-' . $album->id . '-upload', $uploadSessionCount);

            //add user points
            CUserPoints::assignPoint('photo.upload');

            // Photo upload was successfull, display a proper message
            $this->_showUploadError(false, JText::sprintf('COM_COMMUNITY_PHOTO_UPLOADED_SUCCESSFULLY', $photoTable->caption), $photoTable->getThumbURI(), $album->id, $photoTable->id);
        }
        $this->cacheClean(array(COMMUNITY_CACHE_TAG_FRONTPAGE, COMMUNITY_CACHE_TAG_ACTIVITIES));
        exit;
    }

}


