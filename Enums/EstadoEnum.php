<?php

class EstadoEnum {
    const BUENO = 'BUENO';
    const MALO = 'MALO';
    const REGULAR = 'REGULAR';
    const NO_APLICA = 'NO_APLICA';

    public static function getOptions(): array {
        return [
            self::BUENO => 'Bueno',
            self::MALO => 'Malo',
            self::REGULAR => 'Regular',
            self::NO_APLICA => 'No Aplica'
        ];
    }
}