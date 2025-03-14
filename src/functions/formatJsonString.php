<?php
function formatJsonString($inputString) {
    // Decodificar caracteres de escape y eliminar los delimitadores innecesarios
    $inputString = str_replace(["\n", "\t"], "", $inputString);
    
    // Extraer el contenido JSON dentro de ```json ... ```
    if (preg_match('/content:`{3}json(.*?)`{3},/s', $inputString, $matches)) {
        $jsonContent = trim($matches[1]);
    } else {
        return "Error: No se encontró contenido JSON válido.";
    }
    
    // Extraer el titleSlug y metadescription
    preg_match('/titleSlug:(.*?),\n/s', $inputString, $titleMatch);
    preg_match('/metadescription:(.*?)\n?}/s', $inputString, $metaMatch);
    
    $titleSlug = isset($titleMatch[1]) ? trim($titleMatch[1]) : "";
    $metaDescription = isset($metaMatch[1]) ? trim($metaMatch[1]) : "";
    
    // Convertir el JSON contenido en un array asociativo
    $decodedJson = json_decode($jsonContent, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return "Error al decodificar JSON: " . json_last_error_msg();
    }
    
    // Construir el JSON final con los valores extraídos
    $finalJson = [
        "content" => $decodedJson,
        "titleSlug" => $titleSlug,
        "metadescription" => $metaDescription
    ];
    
    return json_encode($finalJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
