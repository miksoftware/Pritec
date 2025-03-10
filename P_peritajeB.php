<?php

class FacturacionElectronica {
    private $config;
    private $endpoint = '/v1/bills/validate';
    private $maxRetries = 1;

    public function __construct() {
        $this->config = Config::getInstance();
    }

    public function enviarFactura($datosVenta) {
        return $this->realizarPeticion($datosVenta);
    }

    private function realizarPeticion($datosVenta, $retry = 0) {
        // Definir ruta del archivo log
        $logFile = dirname(__DIR__) . '/logs/facturacion_api_' . date('Y-m-d') . '.log';
        
        // Función para escribir en el log
        function writeApiLog($logFile, $message) {
            $timestamp = date('Y-m-d H:i:s');
            file_put_contents(
                $logFile, 
                "[$timestamp] $message" . PHP_EOL, 
                FILE_APPEND
            );
        }

        try {
            writeApiLog($logFile, "=== INICIO PETICIÓN FACTURACIÓN ===");
            writeApiLog($logFile, "Datos a validar: " . json_encode($datosVenta));
            
            // Validar datos requeridos
            $this->validarDatosVenta($datosVenta);
            writeApiLog($logFile, "Datos validados correctamente");
            
            $token = $this->config->getAuthToken();
            writeApiLog($logFile, "Token obtenido: $token");
            
            $datosFactura = $this->prepararDatosFactura($datosVenta);
            writeApiLog($logFile, "Datos preparados: " . json_encode($datosFactura));

            $ch = curl_init($this->config->getBaseUrl() . $this->endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datosFactura));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: ' . $this->config->getFullAuthHeader(),
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            writeApiLog($logFile, "Enviando datos a la API...");

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            writeApiLog($logFile, "Respuesta HTTP ($httpCode): $response");

            if (curl_errno($ch)) {
                $curlError = curl_error($ch);
                writeApiLog($logFile, "Error Curl: $curlError");
                throw new Exception('Error Curl: ' . $curlError);
            }

            curl_close($ch);

            // Manejar errores de autorización
            if ($httpCode === 401 && $retry < $this->maxRetries) {
                writeApiLog($logFile, "Token expirado, intentando refrescar...");
                
                if ($this->config->refreshAuthToken()) {
                    return $this->realizarPeticion($datosVenta, $retry + 1);
                }
                throw new Exception('No se pudo refrescar el token de autorización');
            }

            if ($httpCode === 200) {
                $responseData = json_decode($response, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $jsonError = json_last_error_msg();
                    writeApiLog($logFile, "Error al decodificar JSON: $jsonError");
                    throw new Exception('Error al decodificar respuesta JSON: ' . $jsonError);
                }
                writeApiLog($logFile, "Petición exitosa: " . json_encode($responseData));
                return ['success' => true, 'data' => $responseData];
            } else {
                throw new Exception('Error API (' . $httpCode . '): ' . $response);
            }

        } catch (Exception $e) {
            writeApiLog($logFile, "ERROR: " . $e->getMessage());
            return [
                'success' => false, 
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        } finally {
            writeApiLog($logFile, "=== FIN PETICIÓN FACTURACIÓN ===\n");
        }
    }

    private function validarDatosVenta($datosVenta) {
        // Campos requeridos principales
        $camposRequeridos = [
            'reference_code',
            'payment_form',
            'payment_method_code',
            'payment_due_date',
            'customer',
            'items'
        ];

        foreach ($camposRequeridos as $campo) {
            if (!isset($datosVenta[$campo])) {
                throw new Exception("El campo $campo es requerido");
            }
        }

        // Validar campos requeridos del cliente
        $camposCliente = [
            'identification',
            'names',
            'legal_organization_id',
            'tribute_id',
            'identification_document_id',
            'municipality_id'
        ];

        foreach ($camposCliente as $campo) {
            if (empty($datosVenta['customer'][$campo])) {
                throw new Exception("El campo customer.$campo es requerido");
            }
        }

        // Validar items
        if (empty($datosVenta['items'])) {
            throw new Exception('Debe incluir al menos un item');
        }

        foreach ($datosVenta['items'] as $index => $item) {
            $camposItem = [
                'code_reference',
                'name',
                'quantity',
                'price',
                'tax_rate'
            ];

            foreach ($camposItem as $campo) {
                if (!isset($item[$campo])) {
                    throw new Exception("El campo $campo es requerido en el item $index");
                }
            }

            // Validar que quantity sea mayor que 0
            if ((int)$item['quantity'] <= 0) {
                throw new Exception("La cantidad debe ser mayor que 0 en el item $index");
            }

            // Validar que price sea mayor que 0
            if ((float)$item['price'] <= 0) {
                throw new Exception("El precio debe ser mayor que 0 en el item $index");
            }

            // Validar withholding_taxes si existe
            if (isset($item['withholding_taxes']) && is_array($item['withholding_taxes'])) {
                foreach ($item['withholding_taxes'] as $taxIndex => $tax) {
                    if (!isset($tax['code']) || !isset($tax['withholding_tax_rate'])) {
                        throw new Exception("Los campos code y withholding_tax_rate son requeridos en withholding_taxes[$taxIndex]");
                    }
                }
            }
        }
    }

    private function prepararDatosFactura($datosVenta) {
        // Calcular fechas del periodo de facturación
         $currentDate = date('Y-m-d');
        $currentDateEnd = date('Y-m-d', strtotime('+1 day'));
    $currentTime = date('H:i:s');
    
    return [
        "reference_code" => $datosVenta['reference_code'],
        "observation" => $datosVenta['observation'] ?? '',
        "payment_form" => $datosVenta['payment_form'],
        "payment_due_date" => $datosVenta['payment_due_date'],
        "payment_method_code" => $datosVenta['payment_method_code'],
        
        "billing_period" => [
            "start_date" => $currentDate,
            "start_time" => $currentTime,
            "end_date" => $currentDateEnd,
            "end_time" => $currentTime
        ],
            
            "customer" => [
                "identification" => $datosVenta['customer']['identification'],
                "dv" => $datosVenta['customer']['dv'] ?? '',
                "company" => $datosVenta['customer']['company'] ?? '',
                "trade_name" => $datosVenta['customer']['trade_name'] ?? '',
                "names" => $datosVenta['customer']['names'],
                "address" => $datosVenta['customer']['address'] ?? '',
                "email" => $datosVenta['customer']['email'] ?? '',
                "phone" => $datosVenta['customer']['phone'] ?? '',
                "legal_organization_id" => $datosVenta['customer']['legal_organization_id'],
                "tribute_id" => $datosVenta['customer']['tribute_id'],
                "identification_document_id" => $datosVenta['customer']['identification_document_id'],
                "municipality_id" => $datosVenta['customer']['municipality_id']
            ],
            
            "items" => array_map(function($item) {
                return [
                    "code_reference" => $item['code_reference'],
                    "name" => $item['name'],
                    "quantity" => (int)$item['quantity'],
                    "discount_rate" => (float)($item['discount_rate'] ?? 0),
                    "price" => (float)$item['price'],
                    "tax_rate" => number_format((float)$item['tax_rate'], 2, '.', ''),
                    "unit_measure_id" => $item['unit_measure_id'] ?? 70,
                    "standard_code_id" => $item['standard_code_id'] ?? 1,
                    "is_excluded" => $item['is_excluded'] ?? 0,
                    "tribute_id" => 4,
                    "withholding_taxes" => $item['withholding_taxes'] ?? []
                ];
            }, $datosVenta['items'])
        ];
    }
}