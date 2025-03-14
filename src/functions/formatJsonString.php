<?php
function AVAGB_formatJsonString($inputString) {
    // Eliminar saltos de línea y tabulaciones innecesarias
    $inputString = str_replace(["\n", "\t","\r","\\n"], "", $inputString);
    $inputString = str_replace(['\\"'], '"', $inputString);
    $inputString = str_replace(['""'], '"', $inputString);


    // Extraer el contenido JSON dentro de ```json ... ```
    if (preg_match('/content:"(.*?)"\s*,\s*titleSlug/s', $inputString, $matches)) {
        $jsonContent = trim($matches[1]);
        $jsonContent = preg_replace('/^json\s*/i', '', $jsonContent);
        $jsonContent = str_replace("```json", "", $jsonContent);
        $jsonContent = str_replace("```", "", $jsonContent);
    } else {
        throw new Exception("Error: No se encontró contenido JSON válido.");
    }

    // var_dump($inputString);
    // Extraer titleSlug y metadescription
    preg_match('/titleSlug:"(.*?)"/s', $inputString, $titleMatch);
    preg_match('/metadescription:"(.*?)"/s', $inputString, $metaMatch);
    $titleSlug = $titleMatch[1] ?? "";
    $metaDescription = $metaMatch[1] ?? "";

    // var_dump($titleSlug);
    // var_dump($jsonContent);
    // Eliminar barras invertidas innecesarias
    // $jsonContent = stripslashes($jsonContent);
    $decodedJson = json_decode($jsonContent, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error al decodificar JSON: " . json_last_error_msg());
    }

    // Construir el JSON final con los valores extraídos
    $finalJson = [
        "content" => $decodedJson,
        "titleSlug" => $titleSlug,
        "metadescription" => $metaDescription
    ];

    return $finalJson;
}
