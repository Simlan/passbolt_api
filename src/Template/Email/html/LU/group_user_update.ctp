<?php
/**
 * Passbolt ~ Open source password manager for teams
 * Copyright (c) Passbolt SARL (https://www.passbolt.com)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Passbolt SARL (https://www.passbolt.com)
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://www.passbolt.com Passbolt(tm)
 * @since         2.0.0
 */
use App\Utility\Purifier;
use Cake\Routing\Router;

$admin = $body['admin'];
$group = $body['group'];
$groupUser = $body['group_user'];

echo $this->element('email/module/avatar',[
    // @TODO avatar url in email
    'url' => Router::url('/img/avatar' . DS . 'user.png', true),
    'text' => $this->element('email/module/avatar_text', [
        'username' => Purifier::clean($admin->username),
        'first_name' => Purifier::clean($admin->profile->first_name),
        'last_name' => Purifier::clean($admin->profile->last_name),
        'datetime' => $groupUser->modified,
        'text' => __('{0} updated your group membership', null)
    ])
]);

if ($groupUser->is_admin) {
    $text = __('You are now a group manager of this group.');
    $text .= ' ' . __('As group manager you are now authorized to edit the members of this group.');
    $text .= ' ' . __('As member of the group you still have access to all the passwords that are shared with this group.');
} else {
    $text = __('You are no longer a group manager of this group.');
    $text .= ' ' . __('You are no longer authorized to edit the members of this group.');
    $text .= ' ' . __('As member of the group you still have access to all the passwords that are shared with this group.');
}

echo $this->element('email/module/text', [
    'text' => $text
]);

echo $this->element('email/module/button', [
    'url' => Router::url('/'),
    'text' => __('log in passbolt')
]);