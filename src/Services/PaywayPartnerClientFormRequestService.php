<?php

namespace PhpPaywayPartner\Services;

use PhpPaywayPartner\Models\PaywayPartner;
use PhpPaywayPartner\Models\Requests\PaywayPartnerCheckMerchant;
use PhpPaywayPartner\Models\Requests\PaywayPartnerRegisterMerchant;

class PaywayPartnerClientFormRequestService
{

    public function __construct(public PaywayPartner $partner)
    {
    }

    /**
     * allow to pre generate the correct data for form submit when send create request register merchant
     *
     * @param PaywayPartnerRegisterMerchant $requestData
     * @param string|null $requestTime
     * @return array
     */
    public function generateRegisterMerchantFormData(PaywayPartnerRegisterMerchant $requestData, ?string $requestTime = null): array
    {
        $data = $requestData->toMap();
        $_requestData = $this->opensslEncrypt(json_encode($data), $this->partner->partnerPublicKey);
        $_requestTime = $requestTime ?? date("Ymdhis");
        $service = (new PaywayPartnerClientService($this->partner));
        $str = $service->getStr($_requestTime, $_requestData);
        $hash = $service->getHash($str);
        return [
            "request_time" => $_requestTime,
            "request_data" => $_requestData,
            "partner_id" => $this->partner->partnerID,
            "hash" => $hash,
        ];

    }

    public function generateCheckMerchantFormData(PaywayPartnerCheckMerchant $requestData, ?string $requestTime = null)
    {

        $data = $requestData->toMap();
        $_requestData = $this->opensslEncrypt(json_encode($data), $this->partner->partnerPublicKey);
        $_requestTime = $requestTime ?? date("Ymdhis");
        $service = (new PaywayPartnerClientService($this->partner));
        $str = $service->getStr($_requestTime, $_requestData);
        $hash = $service->getHash($str);

        return [
            "request_time" => $_requestTime,
            "request_data" => $_requestData,
            "partner_id" => $this->partner->partnerID,
            "hash" => $hash,
        ];
    }

    public function opensslEncrypt($source, $publicKey)
    {
        // Assumes 1024 bit key and encrypts in chunks.
        $maxlength = 117;
        $output = '';
        while ($source) {
            $input = substr($source, 0,
                $maxlength);
            $source = substr($source,
                $maxlength);
            $ok = openssl_public_encrypt($input, $encrypted, $publicKey);
            $output .= $encrypted;
        }
        return base64_encode($output);
    }

    public function opensslDecrypt(string $source, $privateKey)
    {
        // The raw PHP decryption functions appear to work
        // on 128 Byte chunks. So this decrypts long text
        // encrypted with ssl_encrypt().
        $source = base64_decode($source);
        $maxlength = 128;
        $output = '';
        while ($source) {
            $input = substr($source, 0,
                $maxlength);
            $source = substr($source,
                $maxlength);
            $ok = openssl_private_decrypt($input, $out, $privateKey);
            $output .= $out;
        }
        return $output;
    }

}