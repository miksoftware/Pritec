<?php

class EstadoEnum {
    const BUENO = 'BUENO';
    const MALO = 'MALO';
    const REGULAR = 'REGULAR';

    public static function getOptions(): array {
        return [
            self::BUENO => 'Bueno',
            self::MALO => 'Malo',
            self::REGULAR => 'Regular'
        ];
    }
}