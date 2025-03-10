<?php

class ImprontaEnum {
    const ORIGINAL = 'ORIGINAL';
    const REGRABADO = 'REGRABADO';
    const GRABADO_NO_ORIGINAL = 'GRABADO_NO_ORIGINAL';

    public static function getOptions(): array {
        return [
            self::ORIGINAL => 'Original',
            self::REGRABADO => 'Regrabado',
            self::GRABADO_NO_ORIGINAL => 'Grabado no Original'
        ];
    }
}