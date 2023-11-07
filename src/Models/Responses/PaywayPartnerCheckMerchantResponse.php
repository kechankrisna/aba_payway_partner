<?php

namespace PhpPaywayPartner\Models\Responses;


class PaywayPartnerCheckMerchantResponseStatus{
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

class PaywayPartnerCheckMerchantResponse
{
    public ?string $data = null;
    public ?PaywayPartnerCheckMerchantResponseStatus $status = null;

    public function toMap(): array
    {
        return [
            'data' => $this->data,
            'status' => $this->status->toMap(),
        ];
    }
}