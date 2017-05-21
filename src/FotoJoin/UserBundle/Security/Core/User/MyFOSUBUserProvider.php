<?php

namespace FotoJoin\UserBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Util\TokenGenerator;

class MyFOSUBUserProvider extends BaseFOSUBProvider
{
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $email = $response->getEmail(); // get the unique user identifier

        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy(array($property => $email));
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            // ...

            $this->userManager->updateUser($existingUser);
        }
        //we connect current user, set current user id and token
        // ...
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $userEmail = $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);

        // if null just create new user and set it properties
        if (null === $user) {

            $tokenGenerator = new TokenGenerator();
            $user = $this->userManager->createUser();

            $user->setUsername($userEmail);
            $user->setEmail($userEmail);
            $user->setEnabled(true);
            $user->setPassword($tokenGenerator->generateToken());
            $user->setName($response->getRealName());
            $user->addRole('ROLE_USER');
            $user->setConfirmationToken($tokenGenerator->generateToken());
/*
            $resourceOwnerName = $response->getResourceOwner()->getName();
            switch($resourceOwnerName) {
                case 'facebook':
                    $user->setFacebookid($response->getResponse()['id']);
                    $user->setFacebookaccesstoken($response->getAccessToken());
                break;
                case 'google':
                    $user->setGoogleid($response->getResponse()['id']);
                    $user->setGoogleaccesstoken($response->getAccessToken());
                break;
                case 'twitter':
                    $user->setTwitterid($response->getResponse()['id']);
                    $user->setTwitteraccesstoken($response->getAccessToken());
                break;
            }
*/

            $this->userManager->updateUser($user);

            // ... save user to database

            return $user;
        }
        // else update access token of existing user
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken());//update access token
  
        $setter = 'set' . ucfirst($serviceName) . 'Id';
        $user->$setter($response->getResponse()['id']);//update id

        return $user;
    }
}