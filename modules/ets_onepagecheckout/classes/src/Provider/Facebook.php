<?php
/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
 */

namespace Hybridauth\Provider;

if (!defined('_PS_VERSION_')) { exit; }
use Hybridauth\Exception\InvalidArgumentException;
use Hybridauth\Exception\UnexpectedApiResponseException;
use Hybridauth\Adapter\OAuth2;
use Hybridauth\Data;
use Hybridauth\User;

/**
 * Facebook OAuth2 provider adapter.
 *
 * Example:
 *
 *   $config = [
 *       'callback' => Hybridauth\HttpClient\Util::getCurrentUrl(),
 *       'keys'     => [ 'id' => '', 'secret' => '' ],
 *       'scope'    => 'email, user_status, user_posts'
 *   ];
 *
 *   $adapter = new Hybridauth\Provider\Facebook( $config );
 *
 *   try {
 *       $adapter->authenticate();
 *
 *       $userProfile = $adapter->getUserProfile();
 *       $tokens = $adapter->getAccessToken();
 *       $response = $adapter->setUserStatus("Hybridauth test message..");
 *   }
 *   catch( Exception $e ){
 *       echo $e->getMessage() ;
 *   }
 */
class Facebook extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    protected $scope = 'email, public_profile';//, user_friends, publish_actions

    /**
     * {@inheritdoc}
     */
    protected $apiBaseUrl = 'https://graph.facebook.com/v21.0/';

    /**
     * {@inheritdoc}
     */
    protected $authorizeUrl = 'https://www.facebook.com/dialog/oauth';

    /**
     * {@inheritdoc}
     */
    protected $accessTokenUrl = 'https://graph.facebook.com/oauth/access_token';

    /**
     * {@inheritdoc}
     */
    protected $apiDocumentation = 'https://developers.facebook.com/docs/facebook-login/overview';

    /**
     * {@inheritdoc}
     */
        /**
     * @var string Profile URL template as the fallback when no `link` returned from the API.
     */
    protected $profileUrlTemplate = 'https://www.facebook.com/%s';
    
    protected function initialize()
    {
        parent::initialize();

        // Require proof on all Facebook api calls
        // https://developers.facebook.com/docs/graph-api/securing-requests#appsecret_proof
        if ($accessToken = $this->getStoredData('access_token')) {
            $this->apiRequestParameters['appsecret_proof'] = call_user_func_array('hash_hmac', array('sha256', $accessToken, $this->clientSecret));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUserProfile()
    {
        $response = $this->apiRequest('me?fields=id,name,first_name,last_name,link,website,gender,locale,about,email,hometown,verified,birthday');

        $data = new Data\Collection($response);

        if (! $data->exists('id')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        $userProfile = new User\Profile();

        $userProfile->identifier  = $data->get('id');
        $userProfile->displayName = $data->get('name');
        $userProfile->firstName   = $data->get('first_name');
        $userProfile->lastName    = $data->get('last_name');
        $userProfile->profileURL  = $data->get('link');
        $userProfile->webSiteURL  = $data->get('website');
        $userProfile->gender      = $data->get('gender');
        $userProfile->language    = $data->get('locale');
        $userProfile->description = $data->get('about');
        $userProfile->email       = $data->get('email');

        // Fallback for profile URL in case Facebook does not provide "pretty" link with username (if user set it).
        if (empty($userProfile->profileURL)) {
            $userProfile->profileURL = $this->getProfileUrl($userProfile->identifier);
        }

        $userProfile->region = $data->filter('hometown')->get('name');

        $photoSize = $this->config->get('photo_size') ?: '150';

        $userProfile->photoURL = $this->apiBaseUrl . $userProfile->identifier . '/picture?width=' . $photoSize . '&height=' . $photoSize;

        $userProfile->emailVerified = $data->get('verified') == 1 ? $userProfile->email : '';

        $user = $this->fetchUserRegion($userProfile);

        return $this->fetchBirthday($user, $data->get('birthday'));
    }

    /**
     * Retrieve the user region.
     *
     * @param User\Profile $userProfile
     *
     * @return \Hybridauth\User\Profile
     */
    protected function fetchUserRegion(User\Profile $userProfile)
    {
        if (! empty($userProfile->region)) {
            $regionArr = explode(',', $userProfile->region);

            if (count($regionArr) > 1) {
                $userProfile->city    = trim($regionArr[0]);
                $userProfile->country = trim($regionArr[1]);
            }
        }

        return $userProfile;
    }

    /**
     * Retrieve the user birthday.
     *
     * @param User\Profile $userProfile
     * @param string $birthday
     *
     * @return \Hybridauth\User\Profile
     */
    protected function fetchBirthday(User\Profile $userProfile, $birthday)
    {
        $result = (new Data\Parser())->parseBirthday($birthday, '/');

        $userProfile->birthYear  = (int) $result[0];
        $userProfile->birthMonth = (int) $result[1];
        $userProfile->birthDay   = (int) $result[2];

        return $userProfile;
    }

    /**
     * /v2.0/me/friends only returns the user's friends who also use the app.
     * In the cases where you want to let people tag their friends in stories published by your app,
     * you can use the Taggable Friends API.
     *
     * https://developers.facebook.com/docs/apps/faq#unable_full_friend_list
     */
    public function getUserContacts()
    {
        $contacts = array();

        $apiUrl = 'me/friends?fields=link,name';

        do {
            $response = $this->apiRequest($apiUrl);

            $data = new Data\Collection($response);

            if (! $data->exists('data')) {
                throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
            }

            if ($data->filter('data')->isEmpty()) {
                continue;
            }

            foreach ($data->filter('data')->toArray() as $item) {
                $contacts[] = $this->fetchUserContact($item);
            }

            if ($data->filter('paging')->exists('next')) {
                $apiUrl = $data->filter('paging')->get('next');

                $pagedList = true;
            } else {
                $pagedList = false;
            }
        } while ($pagedList);

        return $contacts;
    }

    /**
     * Parse the user contact.
     *
     * @param array $item
     *
     * @return \Hybridauth\User\Contact
     */
    protected function fetchUserContact($item)
    {
        $userContact = new User\Contact();

        $item = new Data\Collection($item);

        $userContact->identifier  = $item->get('id');
        $userContact->displayName = $item->get('name');

        $userContact->profileURL = $item->exists('link')
                                      ?: 'https://www.facebook.com/profile.php?id=' . $userContact->identifier;

        $userContact->photoURL = $this->apiBaseUrl . $userContact->identifier . '/picture?width=150&height=150';

        return $userContact;
    }

    /**
     * {@inheritdoc}
     */
    public function setUserStatus($status, $pageId = 'me')
    {
        $status = is_string($status) ? array('message' => $status) : $status;

        $response = $this->apiRequest("{$pageId}/feed", 'POST', $status);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageStatus($status, $pageId)
    {
        $status = is_string($status) ? array('message' => $status) : $status;

        // Post on user wall.
        if ($pageId === 'me') {
            return $this->setUserStatus($status, $pageId);
        }

        // Retrieve writable user pages and filter by given one.
        $pages = $this->getUserPages(true);
        $pages = array_filter($pages, function ($page) use ($pageId) {
            return $page->id == $pageId;
        });

        if (!$pages) {
            throw new InvalidArgumentException('Could not find a page with given id.');
        }

        $page = reset($pages);

        // Use page access token instead of user access token.
        $headers = array(
            'Authorization' => 'Bearer ' . $page->access_token,
        );

        // Refresh proof for API call.
        $parameters = $status + array(
            'appsecret_proof' => call_user_func_array('hash_hmac', array('sha256', $page->access_token, $this->clientSecret)),
        );

        $response = $this->apiRequest("{$pageId}/feed", 'POST', $parameters, $headers);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserPages($writable = false)
    {
        $pages = $this->apiRequest('me/accounts');

        if (!$writable) {
            return $pages->data;
        }

        // Filter user pages by CREATE_CONTENT permission.
        return array_filter($pages->data, function ($page) {
            return in_array('CREATE_CONTENT', $page->perms);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getUserActivity($stream = 'me')
    {
        $apiUrl = $stream == 'me' ? 'me/feed' : 'me/home';

        $response = $this->apiRequest($apiUrl);

        $data = new Data\Collection($response);

        if (! $data->exists('data')) {
            throw new UnexpectedApiResponseException('Provider API returned an unexpected response.');
        }

        $activities = array();

        foreach ($data->filter('data')->toArray() as $item) {
            $activities[] = $this->fetchUserActivity($item);
        }

        return $activities;
    }

    /**
    *
    */
    protected function fetchUserActivity($item)
    {
        $userActivity = new User\Activity();

        $item = new Data\Collection($item);

        $userActivity->id   = $item->get('id');
        $userActivity->date = $item->get('created_time');

        if ('video' == $item->get('type') || 'link' == $item->get('type')) {
            $userActivity->text = $item->get('link');
        }

        if (empty($userActivity->text) && $item->exists('story')) {
            $userActivity->text = $item->get('link');
        }

        if (empty($userActivity->text) && $item->exists('message')) {
            $userActivity->text = $item->get('message');
        }

        if (! empty($userActivity->text) && $item->exists('from')) {
            $userActivity->user->identifier  = $item->filter('from')->get('id');
            $userActivity->user->displayName = $item->filter('from')->get('name');

            $userActivity->user->profileURL  = 'https://www.facebook.com/profile.php?id=' . $userActivity->user->identifier;

            $userActivity->user->photoURL    = $this->apiBaseUrl . $userActivity->user->identifier . '/picture?width=150&height=150';
        }

        return $userActivity;
    }

    /**
     * Get profile URL.
     *
     * @param int $identity User ID.
     * @return string|null NULL when identity is not provided.
     */
    protected function getProfileUrl($identity)
    {
        if (!is_numeric($identity)) {
            return null;
        }

        return sprintf($this->profileUrlTemplate, $identity);
    }
}
