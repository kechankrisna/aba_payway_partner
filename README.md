Usage example:

## PaywayPartnerService is required
```php
$partner = new PaywayPartner(
        partnerName: $_ENV['ABA_PARTNER_NAME'] ?? '',
        partnerID: $_ENV['ABA_PARTNER_ID'] ?? '',
        partnerKey: $_ENV['ABA_PARTNER_KEY'] ?? '',
        partnerPrivateKey: utf8_decode(base64_decode($_ENV['ABA_PARTNER_PRIVATE_KEY'] ?? "")),
        partnerPublicKey: utf8_decode(base64_decode($_ENV['ABA_PARTNER_PUBLIC_KEY'] ?? "")),
        baseApiUrl: $_ENV['ABA_PARTNER_API_URL'] ?? '',
    );
    $service = new PaywayPartnerService($partner);
```

## by register a new merchant, the merchant field is required

```php
$merchant = new PaywayPartnerRegisterMerchant(
        pushback_url: 'https://www.mylekha.org/',
        redirect_url: 'https://www.mylekha.org/',
        type: 0,
        register_ref: "Merchant003",
    );
    $response = $service->registerMerchant($merchant);

```

## by checking the new registered merchant, the register_ref is required
```php
$merchant = new PaywayPartnerCheckMerchant(
        register_ref: "Merchant003",
    );
    $service = new PaywayPartnerService($partner);

    $response = $service->checkMerchant(merchant: $merchant);
```

### to get hash string please use PaywayPartnerClientService

```php
$service = (new PaywayPartnerClientService($partner));
$str = $service->getStr($requestTime, $requestData);
$hash = $service->getHash($str);
```

### to encrypt and decrypt using public key and private please use: PaywayPartnerClientFormRequestService

```php
$service = PaywayPartnerClientFormRequestService($partner);
$encrypted = $service.opensslEncrypt(json_encode($data), $partner.partnerPublicKey);
$decrypted = $service.opensslEncrypt(json_encode($data), $partner.partnerPrivateKey);
```
# NOTE:
`please look flutte example folder for more information` 