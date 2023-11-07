<?php

namespace PhpPaywayPartner\Models\Requests;

class PaywayPartnerCheckMerchant
{
    public string $register_ref;

    public function __construct(string $register_ref)
    {
        $this->register_ref = $register_ref;
    }

    public function toMap(): array
    {
        return [
            'register_ref' => $this->register_ref,
        ];
    }
}