<?php
/**
 * Notification class for Helpdesk module.
 *
 * This software is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License version 3 as published by the Free Software Foundation
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 */

/**
 * Notification class for Helpdesk module.
 *
 * @copyright  Copyright (c) 2010 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 */
class Helpdesk_Models_Notification extends Phprojekt_Notification
{
    /**
     * Returns the recipients for this Helpdesk item.
     *
     * @return array Array with user IDs.
     */
    public function getTo()
    {
        $userId = Phprojekt_Auth::getUserId();

        // Gets only the recipients with at least a 'read' right.
        $recipients = parent::getTo();

        // Assigned user
        if ($this->_model->assigned != $userId) {
            $recipients[] = $this->_model->assigned;
        }

        // Author user
        if ($this->_model->author != $userId) {
            $recipients[] = $this->_model->author;
        }

        // Owner user
        if ($this->_model->ownerId != $userId) {
            $recipients[] = $this->_model->ownerId;
        }

        // If the item has been reassigned, add the previous assigned user to the recipients
        $history = new Phprojekt_History();
        $olUser  = $history->getLastAssignedUser($this->_model, 'assigned');
        if ($olUser > 0) {
            $recipients[] = $olUser;
        }

        // Return without duplicates
        return array_unique($recipients);
    }
}
