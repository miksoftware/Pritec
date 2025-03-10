<?php

class SeguroEnum {
    const VIGENTE = 'VIGENTE';
    const NO_VIGENTE = 'NO_VIGENTE';
    const NO_APLICA = 'NO_APLICA';

    public static function getOptions(): array {
        return [
            self::VIGENTE => 'Vigente',
            self::NO_VIGENTE => 'No Vigente',
            self::NO_APLICA => 'No Aplica'
        ];
    }
}