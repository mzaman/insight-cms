<?php

namespace App\Domains\V1\Yaml\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Symfony\Component\Yaml\Yaml;

class YamlController extends Controller
{
    public function getYamlContent()
    {
        // Path to the YAML file
        $filePath = public_path('test-form/swagger.yaml'); // You can adjust the path as needed

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

        // Return the parsed data (you can format it as JSON or plain text)
        return response()->json($data);  // This will return the content as JSON
    }
}