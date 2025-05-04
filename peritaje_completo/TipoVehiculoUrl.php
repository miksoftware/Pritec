<?php

class TipoVehiculoUrl
{
    public string $urlCarroceria;
    public string $urlEstructura;

    public string $urlChasis;

    public function __construct(string $urlCarroceria, string $urlEstructura, string $urlChasis) {
        $this->urlCarroceria = $urlCarroceria;
        $this->urlEstructura = $urlEstructura;
        $this->urlChasis = $urlChasis;
    }
}