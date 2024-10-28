<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Controllers\Controller;
use App\Http\Requests\Onboarding\SubscriberStoreRequest;
use App\Models\EmailSubscriber;
use App\Models\User;
use Inertia\Inertia;

class SubscribersController extends Controller
{
    public function index()
    {
        if (auth()->user()->blog->subscriptions->isNotEmpty()) {
            return redirect()->route('onboarding.complete');
        }

        return Inertia::render('Onboarding/Subscribers');
    }


    public function store(SubscriberStoreRequest $request)
    {
        $blog             = $request->user()->blog;
        $subscriberEmails = $this->getSubscriberEmails($request);

        $users               = User::whereIn('email', $subscriberEmails)->get();
        $emailSubscribers    = EmailSubscriber::whereIn('email', $subscriberEmails)->get();
        $newEmailSubscribers = $this->createNewEmailSubscribers($subscriberEmails, $users, $emailSubscribers);

        $this->createSubscriptions($blog, $users, $emailSubscribers, $newEmailSubscribers);

        return redirect()->route('onboarding.complete');
    }

    private function getSubscriberEmails($request): array
    {
        return array_filter([
            $request->validated('subscriber_1'),
            $request->validated('subscriber_2'),
            $request->validated('subscriber_3'),
            $request->validated('subscriber_4'),
            $request->validated('subscriber_5'),
        ]);
    }

    private function createNewEmailSubscribers($subscriberEmails, $users, $emailSubscribers)
    {
        return collect($subscriberEmails)
            ->diff($users->pluck('email'))
            ->diff($emailSubscribers->pluck('email'))
            ->map(function ($email) {
                return EmailSubscriber::create([
                    'email' => $email,
                ]);
            });
    }

    private function createSubscriptions($blog, $users, $emailSubscribers, $newEmailSubscribers)
    {
        $blog->subscriptions()->createMany(
            $newEmailSubscribers->merge($emailSubscribers)->merge($users)->map(function ($subscriber) {
                return [
                    'subscriber_id'   => $subscriber->id,
                    'subscriber_type' => $subscriber instanceof User ? User::class : EmailSubscriber::class,
                ];
            })->toArray()
        );
    }
}
