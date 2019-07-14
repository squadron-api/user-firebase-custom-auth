<?php

namespace Squadron\Firebase\Auth\Listeners;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Squadron\User\Events\TokenCreated;

class CreateFirebaseCustomAuthToken
{
    /**
     * Handle the event.
     *
     * @param TokenCreated $event
     */
    public function handle(TokenCreated $event): void
    {
        $responseKey = config('squadron.firebaseAuth.responseKey', 'firebase_token');

        $serviceAccount = ServiceAccount::fromJsonFile(storage_path(config('squadron.firebaseAuth.serviceAccountPath')));
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        $customToken = $firebase->getAuth()->createCustomToken($event->user->getKey());

        $event->tokenData[$responseKey] = (string) $customToken;
    }
}
