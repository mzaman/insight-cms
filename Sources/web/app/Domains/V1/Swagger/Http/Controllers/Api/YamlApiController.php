<?php

namespace App\Domains\V1\Swagger\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\Yaml\Yaml;

class YamlApiController extends Controller
{
    /**
     * Retrieve and parse the YAML file.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getYaml()
    {
        // Path to the YAML file
        $filePath = storage_path('app/public/swagger.yaml'); // Adjust path if needed

        // Check if the file exists
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Parse the YAML file using Symfony Yaml component
        try {
            $data = Yaml::parseFile($filePath);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to parse YAML file'], 500);
        }

        // Return the parsed data as JSON
        return response()->json($data);
    }
}
