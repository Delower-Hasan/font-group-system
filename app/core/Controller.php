<?php

namespace Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require_once "../app/views/{$view}.php";
    }

    public function json($data, $status = 200) {
        try {
            // Set headers first
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            
            // Set status code
            http_response_code($status);

            // Format API response
            $response = [
                'status' => $status,
                'success' => $status >= 200 && $status < 300,
                'data' => $data,
                'timestamp' => date('Y-m-d H:i:s')
            ];

            // If it's an error response, format it differently
            if ($status >= 400) {
                $response = [
                    'status' => $status,
                    'success' => false,
                    'error' => [
                        'message' => $data['message'] ?? 'An error occurred',
                        'errors' => $data['errors'] ?? null,
                        'timestamp' => date('Y-m-d H:i:s')
                    ]
                ];
            }

            $jsonResponse = json_encode($response);
            
            if ($jsonResponse === false) {
                throw new \Exception('JSON encoding failed: ' . json_last_error_msg());
            }

            // Output the response
            echo $jsonResponse;
            exit;
        } catch (\Exception $e) {
            // Handle any errors during JSON encoding
            http_response_code(500);
            echo json_encode([
                'status' => 500,
                'success' => false,
                'error' => [
                    'message' => 'Internal Server Error',
                    'details' => $e->getMessage(),
                    'timestamp' => date('Y-m-d H:i:s')
                ]
            ]);
            exit;
        }
    }

    // Helper method for success responses
    public function success($data, $message = 'Success', $status = 200) {
        return $this->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }

    // Helper method for error responses
    public function error($message, $errors = null, $status = 400) {
        return $this->json([
            'message' => $message,
            'errors' => $errors
        ], $status);
    }

    // Pagination Response
    public function paginate($data, $total, $perPage, $currentPage, $message = 'Success') {
        return $this->json([
            'message' => $message,
            'data' => $data,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $currentPage,
                'last_page' => ceil($total / $perPage)
            ]
        ]);
    }

    // File Upload Response
    public function fileResponse($file, $message = 'File uploaded successfully') {
        return $this->json([
            'message' => $message,
            'data' => [
                'filename' => $file['name'],
                'size' => $file['size'],
                'type' => $file['type'],
                'path' => $file['path'] ?? null
            ]
        ], 201);
    }

    // Validation Response
    public function validationError($errors, $message = 'Validation failed') {
        return $this->error($message, $errors, 422);
    }

    // Not Found Response
    public function notFound($message = 'Resource not found') {
        return $this->error($message, null, 404);
    }

    // Unauthorized Response
    public function unauthorized($message = 'Unauthorized access') {
        return $this->error($message, null, 401);
    }

    // Forbidden Response
    public function forbidden($message = 'Access forbidden') {
        return $this->error($message, null, 403);
    }

    // Validation Helper
    public function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            if (strpos($rule, 'required') !== false && (empty($data[$field]) || (is_array($data[$field]) && count($data[$field]) == 0))) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
            
            if (strpos($rule, 'email') !== false && !empty($data[$field]) && is_string($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = 'Invalid email format';
            }
            
            if (strpos($rule, 'min:') !== false) {
                $min = substr($rule, strpos($rule, 'min:') + 4);
                if (!empty($data[$field]) && is_string($data[$field]) && strlen($data[$field]) < $min) {
                    $errors[$field] = ucfirst($field) . " must be at least {$min} characters";
                }
            }
        }
        
        return $errors;
    }
} 