<?php

namespace PhpPaywayPartner\Models\Requests;

class PaywayPartnerRegisterMerchant
{
    public string $pushback_url;
    public string $redirect_url;
    public int $type;
    public string $register_ref;

    public function __construct(
        string $pushback_url,
        string $redirect_url,
        int $type,
        string $register_ref
    )
    {
        $this->register_ref = $register_ref;
        $this->type = $type;
        $this->redirect_url = $redirect_url;
        $this->pushback_url = $pushback_url;
    }

    public function toMap(): array
    {
        return [
            'register_ref' => $this->register_ref,
            'type' => $this->type,
            'redirect_url' => $this->redirect_url,
            'pushback_url' => $this->pushback_url,
        ];
    }
}