<?php

namespace PhpPaywayPartner\Models;

class PaywayPartner
{

    public string $partnerName;
    public string $partnerID;
    public string $partnerKey;
    public string $partnerPrivateKey;
    public string $partnerPublicKey;
    public string $baseApiUrl;

    public function __construct(
        string $partnerName,
        string $partnerID,
        string $partnerKey,
        string $partnerPrivateKey,
        string $partnerPublicKey,
        string $baseApiUrl
    )
    {
        $this->partnerName = $partnerName;
        $this->partnerID = $partnerID;
        $this->partnerKey = $partnerKey;
        $this->partnerPrivateKey = $partnerPrivateKey;
        $this->partnerPublicKey = $partnerPublicKey;
        $this->baseApiUrl = $baseApiUrl;
    }

    public function toMap(): array
    {
        return [
            'partnerName' => $this->partnerName,
            'partnerID' => $this->partnerID,
            'partnerKey' => $this->partnerKey,
            'partnerPrivateKey' => $this->partnerPrivateKey,
            'partnerPublicKey' => $this->partnerPublicKey,
            'baseApiUrl' => $this->baseApiUrl,
        ];

    }
}