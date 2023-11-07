<?php

namespace PhpPaywayPartner\Services;

use GuzzleHttp;
use GuzzleHttp\Client;
use PhpPaywayPartner\Models\PaywayPartner;

class PaywayPartnerClientService
{

    public Client $client;

    public function __construct(public PaywayPartner $partner)
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => $this->partner->baseApiUrl,
            'headers' => [
                'Accept' => 'application/json',
            ],
            'request.options' => [
                'timeout' => 60,
                'connect_timeout' => 60
            ]
        ]);
    }

    public function getStr(
        string $request_time,
        string $request_data,
    ){
        return $this->partner->partnerID . $request_data . $request_time;
    }

    function getHash($str)
    {
        $hash = hash_hmac('sha256', $str, $this->partner->partnerKey);
        return $hash;
    }

    /// [handleTransactionResponse]
    ///
    /// `This will be describe response from each transaction based on status code`
    static function handleTransactionResponse(int $status): string
    {
        return match ($status) {
            1 => "Invalid Hash, Hash generated is incorrect and not following the guideline to generate the Hash.",
            2 => "Invalid Transaction ID, unsupported characters included in Transaction ID",
            3 => "Invalid Amount format need not include decimal point for KHR transaction. example for USD 100.00 for KHR 100",
            4 => "Duplicate Transaction ID, the transaction ID already exists in PayWay, generate new transaction.",
            5 => "Invalid Continue Success URL, (Main domain must be registered in PayWay backend to use success URL)",
            6 => "Invalid Domain Name (Request originated from non-whitelisted domain need to register domain in PayWay backend)",
            7 => "Invalid Return Param (String must be lesser than 500 chars)",
            9 => "Invalid Limit Amount (The amount must be smaller than value that allowed in PayWay backend)",
            10 => "Invalid Shipping Amount",
            11 => "PayWay Server Side Error",
            12 => "Invalid Currency Type (Merchant is allowed only one currency - USD or KHR)",
            13 => "Invalid Item, value for items parameters not following the guideline to generate the base 64 encoded array of item list.",
            15 => "Invalid Channel Values for parameter topup_channel",
            16 => "Invalid First Name - unsupported special characters included in value",
            17 => "Invalid Last Name",
            18 => "Invalid Phone Number",
            19 => "Invalid Email Address",
            20 => "Required purchase details when checkout",
            21 => "Expired production key",
            default => "other - server-side error",
        };
    }
}