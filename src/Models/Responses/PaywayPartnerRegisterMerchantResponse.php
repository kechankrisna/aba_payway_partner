<?php

namespace PhpPaywayPartner\Models\Responses;


class PaywayPartnerRegisterMerchantResponseStatus
{
    public ?string $code = null;
    public ?string $message = null;
    public ?string $tran_id = null;

    public function __construct(
        ?string $code = null,
        ?string $message = null,
        ?string $tran_id = null,
    )
    {
        $this->code = $code;
        $this->message = $message;
        $this->tran_id = $tran_id;
    }

    /**
     * @param string|null $code
     * @param string|null $message
     * @param string|null $tran_id
     * @return $this
     */
    public function copyWith(
        ?string $code = null,
        ?string $message = null,
        ?string $tran_id = null,
    ): self
    {
        $copy = clone($this);
        $this->code = $code ?? $copy->code;
        $this->message = $message ?? $copy->message;
        $this->tran_id = $tran_id ?? $copy->tran_id;
        return $this;
    }

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

    public function __construct(
        string                                      $url = null,
        string                                      $token = null,
        PaywayPartnerRegisterMerchantResponseStatus $status = null,
    )
    {
        $this->url = $url;
        $this->token = $token;
        $this->status = $status;
    }

    /**
     * @param string|null $url
     * @param string|null $token
     * @param PaywayPartnerRegisterMerchantResponseStatus|null $status
     * @return $this
     */
    public function copyWith(
        ?string                                      $url = null,
        ?string                                      $token = null,
        ?PaywayPartnerRegisterMerchantResponseStatus $status = null,
    ): self
    {
        $copy = clone($this);
        $this->url = $url ?? $copy->url;
        $this->token = $token ?? $copy->token;
        $this->status = $status ?? $copy->status;
        return $this;
    }

    public function toMap(): array
    {
        return [
            'url' => $this->url,
            'token' => $this->token,
            'status' => $this->status->toMap(),
        ];
    }
}