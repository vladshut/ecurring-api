<?php

declare(strict_types=1);

namespace VladShut\eCurring\Http\Resource;

use DateTime;
use VladShut\eCurring\Http\Resource\Exception\UnPostableEntityException;
use VladShut\eCurring\Resource\Customer;
use VladShut\eCurring\Resource\Subscription;
use VladShut\eCurring\Resource\Transaction;

final class CreateParser implements CreateParserInterface
{
    /**
     * @throws UnPostableEntityException
     */
    public function parse(Creatable $object): array
    {
        if ($object instanceof Customer) {
            return $this->getCustomerPostData($object);
        }

        if ($object instanceof Subscription) {
            return $this->getSubscriptionPostData($object);
        }

        if ($object instanceof Transaction) {
            return $this->getTransactionPostData($object);
        }
    }


    private function getCustomerPostData(Customer $customer): array
    {
        $data = [
            'first_name' => $customer->getFirstName(),
            'last_name' => $customer->getLastName(),
            'email' => $customer->getEmail(),
        ];

        if ($customer->getGender()) {
            $data['gender'] = $customer->getGender();
        }

        if ($customer->getMiddleName()) {
            $data['middle_name'] = $customer->getMiddleName();
        }

        if ($customer->getCompanyName()) {
            $data['company_name'] = $customer->getCompanyName();
        }

        if ($customer->getVatNumber()) {
            $data['vat_number'] = $customer->getVatNumber();
        }

        if ($customer->getPostalcode()) {
            $data['postalcode'] = $customer->getPostalcode();
        }

        if ($customer->getHouseNumber()) {
            $data['house_number'] = $customer->getHouseNumber();
        }

        if ($customer->getHouseNumberAdd()) {
            $data['house_number_add'] = $customer->getHouseNumberAdd();
        }

        if ($customer->getStreet()) {
            $data['street'] = $customer->getStreet();
        }

        if ($customer->getCity()) {
            $data['city'] = $customer->getCity();
        }

        if ($customer->getCountryCode()) {
            $data['country_iso2'] = $customer->getCountryCode();
        }

        if ($customer->getLanguage()) {
            $data['language'] = $customer->getLanguage();
        }

        if ($customer->getTelephone()) {
            $data['telephone '] = $customer->getTelephone();
        }

        return [
            'data' => [
                'type' => 'customer',
                'attributes' => $data
            ]
        ];
    }

    /**
     * @throws UnPostableEntityException
     */
    private function getSubscriptionPostData(Subscription $subscription): array
    {
        if (!$subscription->getCustomer()) {
            throw new UnPostableEntityException('Missing required field `customer`. Make sure you create a new subscription using Subscription::new()');
        }

        if (!$subscription->getSubscriptionPlan()) {
            throw new UnPostableEntityException('Missing required field `subscriptionPlan`. Make sure you create a new subscription using Subscription::new()');
        }

        $data = [
            'customer_id' => $subscription->getCustomer()->getId(),
            'subscription_plan_id' => $subscription->getSubscriptionPlan()->getId(),
        ];

        if ($subscription->getMandate()) {
            $data['mandate_code'] = $subscription->getMandate()->getCode();
            $data['mandate_accepted'] = $subscription->getMandate()->isAccepted();
            $data['mandate_accepted_date'] = $subscription->getMandate()->getAcceptedDate()->format(DateTime::ATOM);
        }

        if ($subscription->getStartDate()) {
            $data['start_date '] = $subscription->getStartDate()->format(DateTime::ATOM);
        }

        if ($subscription->getStatus()) {
            $data['status '] = $subscription->getStatus()->getValue();
        }

        if ($subscription->getCancelDate()) {
            $data['cancel_date '] = $subscription->getCancelDate()->format(DateTime::ATOM);
        }

        if ($subscription->getResumeDate()) {
            $data['resume_date '] = $subscription->getResumeDate()->format(DateTime::ATOM);
        }

        if ($subscription->isConfirmationSent() !== null) {
            $data['confirmation_sent '] = $subscription->isConfirmationSent();
        }

        if ($subscription->getSubscriptionWebhookUrl()) {
            $data['subscription_webhook_url '] = $subscription->getSubscriptionWebhookUrl();
        }

        if ($subscription->getTransactionWebhookUrl()) {
            $data['transaction_webhook_url '] = $subscription->getTransactionWebhookUrl();
        }

        if ($subscription->getSuccessRedirectUrl()) {
            $data['success_redirect_url '] = $subscription->getSuccessRedirectUrl();
        }

        return [
            'data' => [
                'type' => 'subscription',
                'attributes' => $data
            ]
        ];
    }

    /**
     * @throws UnPostableEntityException
     */
    private function getTransactionPostData(Transaction $transaction): array
    {
        if (!$transaction->getSubscription()) {
            throw new UnPostableEntityException('No Subscription found on Transaction. Make sure you create a new transaction using Transaction::new()');
        }

        $data = [
            'subscription_id' => $transaction->getSubscription()->getId(),
            'amount' => ((float)$transaction->getAmount()->getAmount()/100.00),
        ];

        if ($transaction->getDueDate()) {
            $data['due_date'] = $transaction->getDueDate()->format(DateTime::ATOM);
        }

        return $data;
    }
}
