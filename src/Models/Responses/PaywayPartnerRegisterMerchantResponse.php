<?php

namespace PhpPaywayPartner\Models\Responses;


class PaywayPartnerRegisterMerchantResponseStatus
{
    public ?string $code = null;
    public ?string $message = null;
    public ?string $tran_id = null;

    public function toMap(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'tran_id' => $this->tran_id,
        ];
    }
}

class PaywayPartnerRegisterMerchantResponse
{
    public ?string $url = null;
    public ?string $token = null;
    public ?PaywayPartnerRegisterMerchantResponseStatus $status = null;

    public function toMap(): array
    {
        return [
            'url' => $this->url,
            'token' => $this->token,
            'status' => $this->status->toMap(),
        ];
    }
}