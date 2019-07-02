<?php

declare(strict_types=1);

namespace VladShut\eCurring\Http\Resource;

use DateTime;
use VladShut\eCurring\Resource\Customer;
use VladShut\eCurring\Resource\Subscription;

final class UpdateParser implements UpdateParserInterface
{
    public function parse(Updatable $object): array
    {
        if ($object instanceof Customer) {
            return $this->getCustomerPatchData($object);
        }

        if ($object instanceof Subscription) {
            return $this->getSubscriptionPatchData($object);
        }
    }

    private function getCustomerPatchData(Customer $customer): array
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

        return $data;
    }

    private function getSubscriptionPatchData(Subscription $subscription): array
    {
        $data = [];

        if ($subscription->getMandate()) {
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

        return $data;
    }
}
