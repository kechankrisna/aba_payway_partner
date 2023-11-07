<?php

use PhpPaywayPartner\Models\PaywayPartner;
use PhpPaywayPartner\Models\Requests\PaywayPartnerCheckMerchant;
use PhpPaywayPartner\Models\Requests\PaywayPartnerRegisterMerchant;
use PhpPaywayPartner\Services\PaywayPartnerService;
use function PHPUnit\Framework\assertEquals;

uses()->group('PaywayPartnerService');

beforeEach(function () {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
});

test('test register a new merchant and status should be success', function () {

    $partner = new PaywayPartner(
        partnerName: $_ENV['ABA_PARTNER_NAME'] ?? '',
        partnerID: $_ENV['ABA_PARTNER_ID'] ?? '',
        partnerKey: $_ENV['ABA_PARTNER_KEY'] ?? '',
        partnerPrivateKey: utf8_decode(base64_decode($_ENV['ABA_PARTNER_PRIVATE_KEY'] ?? "")),
        partnerPublicKey: utf8_decode(base64_decode($_ENV['ABA_PARTNER_PUBLIC_KEY'] ?? "")),
        baseApiUrl: $_ENV['ABA_PARTNER_API_URL'] ?? '',
    );
    $service = new PaywayPartnerService($partner);


    $merchant = new PaywayPartnerRegisterMerchant(
        pushback_url: 'https://www.mylekha.org/',
        redirect_url: 'https://www.mylekha.org/',
        type: 0,
        register_ref: "Merchant003",
    );
    $response = $service->registerMerchant($merchant);

//    dd($response);

    assertEquals(
        $response != null && strlen($response->url) > 0 &&
        strlen($response->token) > 0,
        true,
        message: "the url and token should be exist according to docs");

    assertEquals(
        strlen($response->status->tran_id) > 0 &&
        strlen($response->status->code) > 0 &&
        strlen($response->status->message) > 0,
        true,
        message: "the status.tran_id,  status.code, status.message should be a string according to docs");
})->group("PaywayMerchantService");


test(
    "test check a new registered merchant status and expect to see no merchant not found", function () {
    $partner = new PaywayPartner(
        partnerName: $_ENV['ABA_PARTNER_NAME'] ?? '',
        partnerID: $_ENV['ABA_PARTNER_ID'] ?? '',
        partnerKey: $_ENV['ABA_PARTNER_KEY'] ?? '',
        partnerPrivateKey: utf8_decode(base64_decode($_ENV['ABA_PARTNER_PRIVATE_KEY'] ?? "")),
        partnerPublicKey: utf8_decode(base64_decode($_ENV['ABA_PARTNER_PUBLIC_KEY'] ?? "")),
        baseApiUrl: $_ENV['ABA_PARTNER_API_URL'] ?? '',
    );
    $merchant = new PaywayPartnerCheckMerchant(
        register_ref: "Merchant003",
    );
    $service = new PaywayPartnerService($partner);

    $response = $service->checkMerchant(merchant: $merchant);


//    dd($response->status);

    assertEquals($response->data == null, true,
        message: "the data should be empty while user not yet complete info according to docs");


})->group("PaywayMerchantService");