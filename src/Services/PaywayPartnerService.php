<?php

namespace PhpPaywayPartner\Services;

use Exception;
use JsonMapper;
use PhpPaywayPartner\Models\PaywayPartner;
use PhpPaywayPartner\Models\Requests\PaywayPartnerCheckMerchant;
use PhpPaywayPartner\Models\Requests\PaywayPartnerRegisterMerchant;
use PhpPaywayPartner\Models\Responses\PaywayPartnerCheckMerchantResponse;
use PhpPaywayPartner\Models\Responses\PaywayPartnerCheckMerchantResponseStatus;
use PhpPaywayPartner\Models\Responses\PaywayPartnerRegisterMerchantResponse;
use PhpPaywayPartner\Models\Responses\PaywayPartnerRegisterMerchantResponseStatus;

class PaywayPartnerService
{

    public function __construct(public PaywayPartner $partner)
    {
    }


    /**
     * register a new merchant
     *
     * @param PaywayPartnerRegisterMerchant $merchant
     * @return PaywayPartnerRegisterMerchantResponse
     */
    public function registerMerchant(PaywayPartnerRegisterMerchant $merchant): PaywayPartnerRegisterMerchantResponse
    {
        $res = new PaywayPartnerRegisterMerchantResponse(url: "",
            token: "",
            status: new PaywayPartnerRegisterMerchantResponseStatus(
                code: "PTL06", message: "The Request is Expired"));

        try {
            $service = new PaywayPartnerClientService(partner: $this->partner);
            $form_service = new PaywayPartnerClientFormRequestService(partner: $this->partner);
            $request_options = $form_service->generateRegisterMerchantFormData(requestData: $merchant);
            $response = $service->client->request("POST", uri: "/api/merchant-portal/online-self-activation/new-merchant", options: [
                'form_params' => $request_options
            ]);

            $data = json_decode($response->getBody()->getContents());

            $mapper = new JsonMapper();

            $res = $mapper->map(json: $data, object: new PaywayPartnerRegisterMerchantResponse());

            return $res;
        } catch (Exception $e) {
//            dd("exc $exception");
            $res = $res->copyWith(
                status: $res->status->copyWith(
                    code: "PTL06",
                    message: $e->getMessage()));
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
//            dd("guz $e");
            $res = $res->copyWith(
                status: $res->status->copyWith(
                    code: "PTL06",
                    message: $e->getMessage()));
        }

        return $res;

    }

    /**
     * check a status merchant
     *
     * @param PaywayPartnerCheckMerchant $merchant
     * @return PaywayPartnerCheckMerchantResponse
     */
    public function checkMerchant(PaywayPartnerCheckMerchant $merchant): PaywayPartnerCheckMerchantResponse
    {
        $res = new PaywayPartnerCheckMerchantResponse(data: "",
            status: new PaywayPartnerCheckMerchantResponseStatus(
                code: "PTL46", message: "Merchant not found"));
        try {
            $service = new PaywayPartnerClientService(partner: $this->partner);
            $form_service = new PaywayPartnerClientFormRequestService(partner: $this->partner);
            $request_options = $form_service->generateCheckMerchantFormData(requestData: $merchant);
            $response = $service->client->request("POST", uri: "/api/merchant-portal/online-self-activation/get-mc-credential-info", options: [
                'form_params' => $request_options
            ]);

            $data = json_decode($response->getBody()->getContents());

            $mapper = new JsonMapper();

            $res = $mapper->map(json: $data, object: new PaywayPartnerCheckMerchantResponse());
            return $res;
        } catch (Exception $e) {
//            dd("exc $exception");
            $res = $res->copyWith(
                status: $res->status->copyWith(
                    code: "PTL46",
                    message: $e->getMessage()));
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
//            dd("guz $e");
            $res = $res->copyWith(
                status: $res->status->copyWith(
                    code: "PTL46",
                    message: $e->getMessage()));
        }

        return $res;
    }
}