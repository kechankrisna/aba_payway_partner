<?php

namespace PhpPaywayPartner\Models\Responses;


class PaywayPartnerCheckMerchantResponseStatus
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

class PaywayPartnerCheckMerchantResponse
{
    public ?string $data = null;
    public ?PaywayPartnerCheckMerchantResponseStatus $status = null;

    public function __construct(
        ?string                                   $data = null,
        ?PaywayPartnerCheckMerchantResponseStatus $status = null,
    )
    {
        $this->data = $data;
        $this->status = $status;
    }

    /**
     * @param string|null $data
     * @param PaywayPartnerCheckMerchantResponseStatus|null $status
     * @return $this
     */
    public function copyWith(
        ?string                                   $data = null,
        ?PaywayPartnerCheckMerchantResponseStatus $status = null,
    ): self
    {
        $copy = clone($this);
        $this->data = $data ?? $copy->data;
        $this->status = $status ?? $copy->status;
        return $this;
    }

    public function toMap(): array
    {
        return [
            'data' => $this->data,
            'status' => $this->status->toMap(),
        ];
    }
}